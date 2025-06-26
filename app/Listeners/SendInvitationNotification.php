<?php

namespace App\Listeners;

use App\Events\InvitationCreated;
use App\Notifications\InviteToHousehold;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvitationNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvitationCreated $event): void
    {
        $invitation = $event->invitation;
        $household = $event->invitation->household;
        $invitedUser = $event->invitation->userInvited();

        if ($invitedUser) {
            $invitedUser->notify(new InviteToHousehold($household, $invitation));
        }
    }
}
