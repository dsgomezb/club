<?php

namespace App\Listeners;

use App\Notifications\SendEmailVerificationNotification as Notification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class SendEmailVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $url = URL::temporarySignedRoute(
            'perfil.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $event->user->id,
                'hash' => sha1($event->user->email),
            ]
        );

        $event->user->notify(new Notification($url));
    }
}
