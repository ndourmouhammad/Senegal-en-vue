<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionRequested extends Notification
{
    use Queueable;

    protected $touriste;
    protected $guide;

    public function __construct($touriste, $guide)
    {
        $this->touriste = $touriste;
        $this->guide = $guide;
    }

    public function via($notifiable)
    {
        return ['database']; // Utilisation des notifications via base de données
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->touriste->name} a demandé à s'abonner à vos services.",
            'touriste_id' => $this->touriste->id,
            'guide_id' => $this->guide->id,
        ];
    }
}
