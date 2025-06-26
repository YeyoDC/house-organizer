<?php

namespace App\Services;

use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;

class InvitationService
{
    public function sendInvitation($household, $user, $email): Invitation
    {
        $invitation = Invitation::create([
            'email' => $email,
            'household_id' => $household->id,
            'invited_by' => $user->id,
        ]);

        return $invitation;
    }

    public function confirmInvitation($invitationId, $action): Invitation
    {
        $invitation = Invitation::findOrFail($invitationId);
        $user = Auth::user();
        if($action == 'accept') {
            if($user->ownedHousehold)
            {
                $user->ownedHousehold->delete();
            }
            $user->household_id = $invitation->household_id;
            $user->save();
            $invitation->status = 'accepted';
            $invitation->save();
        }
        else if ($action == 'reject') {
            $invitation->status = 'declined';
            $invitation->save();
        }
        return $invitation;
    }
}
