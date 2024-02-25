<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class RefuserRendezvousNotification extends Notification
{
    use Queueable;
    protected $rendezvous;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rendezvous)
    {
        $this->rendezvous = $rendezvous;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Le vétérinaire a refusé le rendez-vous.',
            'rendezvous_id' => $this->rendezvous->id,
        ];
    }
}
