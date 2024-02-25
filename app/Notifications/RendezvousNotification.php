<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class RendezvousNotification extends Notification
{
    use Queueable;

    protected $mod;

   

    /**
     * Create a new notification instance.
     *
     * @return void
     */
   
     public function __construct($mod)
    {
        $this->mod = $mod;
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


    public function toDatabase($notifiable) :array
    {
        return [
            'eleveur_id' => $this->mod->id_eleveur,
            'message' => 'Nouveau rendez-vous en attente. Veuillez confirmer ou refuser.',
            'rendezvous_id' => $this->mod->id,
        ];
    }

   
}
