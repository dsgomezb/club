<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $url; 

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function build()
    {
        return $this->markdown('emails.approval-notifiaction')->subject('Bienvenido a ' . config('app.name'));
    }
}
