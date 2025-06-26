<?php

namespace App\Services;

use App\Models\Household;
use App\Models\User;

class HouseholdService
{
    public function createHousehold(User $user, string $name, ?string $description = null): Household
    {
        $household = $user->ownedHousehold()->create([
            'name' => $name,
            'description' => $description,
        ]);

        $user->update(['household_id' => $household->id]);

        return $household;
    }

    public function leaveHousehold($user, $householdId): ?Household
    {
        // If the user owns a household, delete it
        if ($user->ownedHousehold) {
            $user->ownedHousehold->delete();
            return null;
        }

        // If the user is part of a household, leave it
        if ($user->household) {
            $user->household_id = null;
            $user->save();
            return null;
        }

        return null;
    }

}
