<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $info; 

    public function __construct($info)
    {
        $this->info = $info;
    }

    public function build()
    {
        return $this->markdown('emails.ban-notifiaction')->subject('Su usuario ha sido bloqueado');
    }
}
