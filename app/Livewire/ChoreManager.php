<?php

namespace App\Livewire;

use App\Models\Chore;
use App\Models\ChoreOccurrence;
use App\Services\ChoreService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChoreManager extends Component
{
    public $filterMonth;
    public $filterAssigned = '';
    public $showUserListFor = null;

    public function mount()
    {
        $this->filterMonth = now()->format('Y-m');
    }
    public function assignChore($occurrenceId)
    {
        $this->showUserListFor = $occurrenceId;
    }
    public function toggleCompletion($occurrenceId)
    {
        $occurrence = ChoreOccurrence::findOrFail($occurrenceId);
        $occurrence->toggleCompletion();
    }

    public function assignTo($occurrenceId, $userId = null)
    {
        $occurrence = ChoreOccurrence::findOrFail($occurrenceId);
        $occurrence->assignTo($userId);
        $this->showUserListFor = null;
    }
    public function deleteChore($occurrenceId, $all = false)
    {
        $occurrence = ChoreOccurrence::findOrFail($occurrenceId);

        if ($all) {
            $occurrence->chore->delete();
        } else {
            $occurrence->delete();
        }
    }
    public function setFilterMonth($value) { $this->filterMonth = $value; }
    public function setFilterAssigned($value) { $this->filterAssigned = $value; }
    public function goToPreviousMonth() { $this->filterMonth = Carbon::parse($this->filterMonth)->subMonth()->format('Y-m'); }
    public function goToNextMonth() { $this->filterMonth = Carbon::parse($this->filterMonth)->addMonth()->format('Y-m'); }

    public function render()
    {
        $user = Auth::user();

        $groupedOccurrences = app(ChoreService::class)
            ->getHouseholdOccurrencesGrouped($user, $this->filterMonth, $this->filterAssigned);

        return view('livewire.chore-manager', [
            'groupedOccurrences' => $groupedOccurrences,
            'user' => $user,
            'members' => $user->household->members,
            'household' => $user->household,
        ]);
    }
}

