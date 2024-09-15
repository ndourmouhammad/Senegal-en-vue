<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubscriptionResponse extends Notification
{
    use Queueable;

    protected $subscription;
    protected $status;

    public function __construct($subscription, $status)
    {
        $this->subscription = $subscription;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // Utilisation des notifications via base de données
    }

    public function toArray($notifiable)
    {
        $statusMessage = $this->status == 'accepte' ? 'acceptée' : 'rejetée';
        return [
            'message' => "Votre demande d'abonnement a été {$statusMessage}.",
            'subscription_id' => $this->subscription->id,
            'status' => $this->status,
        ];
    }
}
