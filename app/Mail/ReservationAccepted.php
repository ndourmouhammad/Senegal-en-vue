<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ReservationAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Réservation')
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->reservation->user->email)
                    ->view('reservation_confirmed'); // Utilisation d'une vue Blade
    }
}