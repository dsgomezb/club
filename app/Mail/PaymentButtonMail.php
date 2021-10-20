<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentButtonMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment; 

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->markdown('emails.payment-button-mail')->subject('Su próximo pago ya se encuentra disponible');
    }
}
