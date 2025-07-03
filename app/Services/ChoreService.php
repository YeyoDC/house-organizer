<?php

namespace App\Services;

use App\Models\Chore;
use App\Models\ChoreOccurrence;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ChoreService
{
    public function createChore(array $data): Chore
    {
        if (empty($data['end_date'])) {
            $data['end_date'] = null;
        }

        $chore = Chore::create($data);
        $this->generateOccurrences($chore);
        return $chore;
    }

    public function generateOccurrences(Chore $chore): void
    {
        $start = Carbon::parse($chore->start_date);
        $end = $chore->end_date ? Carbon::parse($chore->end_date) : now()->addMonths(3);

        if ($chore->recurrence === 'none') {
            ChoreOccurrence::create([
                'chore_id' => $chore->id,
                'due_date' => $start->toDateString(),
                'assigned_to' => null,
            ]);
            return;
        }

        $interval = match ($chore->recurrence) {
            'daily' => '1 day',
            'weekly' => '1 week',
            'bi-weekly' => '2 weeks',
            'monthly' => '1 month',
            default => '1 week',
        };

        $period = CarbonPeriod::create($start, $interval, $end);
        foreach ($period as $date) {
            ChoreOccurrence::create([
                'chore_id' => $chore->id,
                'due_date' => $date->toDateString(),
                'assigned_to' => null,
            ]);
        }
    }
    public static function getValidationRules(): array
    {
        return [
            'chores' => 'required|array|min:1',
            'chores.*.action_id' => 'required|exists:chore_actions,id',
            'chores.*.location_id' => 'required|exists:chore_locations,id',
            'chores.*.start_date' => 'required|date',
            'chores.*.recurrence' => 'required|in:none,daily,weekly,bi-weekly,monthly',
        ];
    }

    public function getHouseholdOccurrencesGrouped(User $user, ?string $month = null, ?string $assigned = null)
    {
        $chores = Chore::with(['occurrences', 'location', 'action'])
            ->where('household_id', $user->household_id)
            ->get();

        $allOccurrences = collect();

        foreach ($chores as $chore) {
            foreach ($chore->occurrences as $occurrence) {
                $allOccurrences->push([
                    'chore' => $chore,
                    'occurrence' => $occurrence,
                    'due_date' => $occurrence->due_date,
                ]);
            }
        }

        if ($month) {
            $allOccurrences = $allOccurrences->filter(fn($item) =>
                $item['due_date']->format('Y-m') === $month
            );
        }

        if ($assigned === 'unassigned') {
            $allOccurrences = $allOccurrences->filter(fn($item) => is_null($item['occurrence']->assigned_to));
        } elseif ($assigned === 'assigned') {
            $allOccurrences = $allOccurrences->filter(fn($item) => $item['occurrence']->assigned_to);
        } elseif ($assigned !== '') {
            $allOccurrences = $allOccurrences->filter(fn($item) => $item['occurrence']->assigned_to == $assigned);
        }

        return $allOccurrences
            ->sortBy('due_date')
            ->groupBy(fn($item) => $item['due_date']->format('Y-m-d'));
    }

    public function getUpcomingOccurrencesForUserGrouped(int $userId, int $days = 7)
    {
        $occurrences = ChoreOccurrence::with(['chore.action', 'chore.location'])
            ->where('assigned_to', $userId)
            ->whereBetween('due_date', [now(), now()->addDays($days)])
            ->orderBy('due_date')
            ->get();

        return $occurrences
            ->groupBy(fn($item) => $item->due_date->format('Y-m-d'))
            ->map(function ($group) {
                return $group->map(fn($occurrence) => [
                    'chore' => $occurrence->chore,
                    'occurrence' => $occurrence,
                ]);
            });
    }


}

