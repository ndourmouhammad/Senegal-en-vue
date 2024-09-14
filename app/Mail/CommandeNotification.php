<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class CommandeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct($commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Commande')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->commande->user->email)
                    ->view('commande_notification'); // Utilisation d'une vue Blade
    }
}