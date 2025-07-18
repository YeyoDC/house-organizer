<?php

namespace App\Services;
use Illuminate\Support\Collection;

use App\Models\GroceryList;

class GroceryListService
{


    public function getActiveListsForUserOrHousehold(int $userId, int $householdId, string $mode = 'household'): Collection
    {
        return GroceryList::query()
            ->when($mode === 'personal', fn ($q) =>
            $q->where('user_id', $userId)
            )
            ->when($mode === 'household', fn ($q) =>
            $q->where('household_id', $householdId)
            )
            ->where('status', 'active')
            ->orderBy('due_date')
            ->get();
    }
}
