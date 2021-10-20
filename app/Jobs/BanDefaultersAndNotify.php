<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BanDefaultersAndNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $query = \App\User::where('is_banned', 0)
            ->where('is_approved', 1)
            ->whereNotNull('email_verified_at')
            ->whereHas('payments', function ($query) {
                $query->where('date', '<', date('Y-m-d'))->where('payment_status_id', '!=', \App\PaymentStatus::PAID);
            })
        ;

        $query->get()->each(function ($user) {
            $email = new BanNotification($this->getBanMessage());
            \Mail::to($user)->queue($email);
        });

        $query->update(['is_banned', 1]);
    }

    private function getBanMessage()
    {
        $message = 'Lamenentamos informarle que por el incumplimiento del pago mensual su usuario ha sido bloqueado.' . PHP_EOL;
        $message .= 'Si no realiza abona el pago adeudado su usuario será removido permanentemente.'. PHP_EOL;
        return $message;
    }
}
