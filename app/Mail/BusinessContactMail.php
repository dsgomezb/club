<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $post;
    public $sender;

    public function __construct($contactMessage, $post, $sender)
    {
        $this->contactMessage = $contactMessage;
        $this->post = $post;
        $this->sender = $sender;
    }

    public function build()
    {
        return $this->markdown('emails.business-contact')
            ->subject($this->sender->full_name . ' te envió un mensaje.')
            ->replyTo($this->sender->email, $this->sender->full_name)
        ;
    }
}
