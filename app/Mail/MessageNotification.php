<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post; 

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->markdown('emails.message-notifiaction')->subject('Nuevo mensaje');
    }
}
