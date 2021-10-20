<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $sender;

    public function __construct($contactMessage, $sender)
    {
        $this->contactMessage = $contactMessage;
        $this->sender = $sender;
    }

    public function build()
    {
        return $this->markdown('emails.contact')
            ->subject($this->sender->full_name . ' te envió un mensaje.')
            ->replyTo($this->sender->email, $this->sender->full_name)
        ;
    }
}
