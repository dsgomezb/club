<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Estás recibiendo este correo porque solicitaste recuperar tu contraseña.')
            ->action('Modificar contraseña', url('admin/password/reset', $this->token))
            ->line('Si no realizaste ninguna solicitud desestimá este correo.')
        ;
    }
}
