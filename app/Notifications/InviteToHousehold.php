<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteToHousehold extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $household;
    public $invitation;

    public function __construct($household, $invitation)
    {
        $this->household = $household;
        $this->invitation = $invitation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $invitedUser = $this->invitation->userInvited();

        $householdName = $this->invitation->household->name;
        $inviterName = $this->invitation->inviter->name;

        if ($invitedUser) {
            return (new MailMessage)
                ->subject('You have been invited to a household')
                ->line('Hello ' . $invitedUser->name . ', you have received an invitation from ' . $inviterName . ' to join their household "' . $householdName . '".')
                ->action('Accept or Reject Invitation', url('/invite'))
                ->line('Thank you for using our application!');
        }
//        if new user
        return (new MailMessage)
            ->subject('You have been invited to a household')
            ->line('Hello, you have received an invitation from ' . $inviterName . ' to join their household "' . $householdName . '".')
            ->line('You can accept it or reject it by joining us.')
            ->action('Accept or Reject Invitation', url('/invite'))
            ->line('Welcome to our family');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'invitation_id'   => $this->invitation->id,
            'household_id'    => $this->invitation->household_id,
            'household_name'  => $this->invitation->household->name,
            'inviter_id'      => $this->invitation->invited_by,
            'inviter_name'    => $this->invitation->inviter->name,
            'status'          => $this->invitation->status,
            'expires_at'      => $this->invitation->expires_at?->toDateTimeString(),
            'message'         => "You've been invited to join the household \"{$this->invitation->household->name}\" by {$this->invitation->inviter->name}.",
            'action_url'      => route('invite.accept', $this->invitation->id),
        ];
    }
}
