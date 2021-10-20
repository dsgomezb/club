<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment; 

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->markdown('emails.payment-warning-mail')->subject('Su próximo pago está próximo a vencer');
    }
}
