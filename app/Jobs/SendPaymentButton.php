<?php

namespace App\Jobs;

use App\Jobs\CreatePaymentLink;
use App\Mail\PaymentButtonMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentButton implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        //se envía el botón de pago 10 días antes del vencimiento

        $date = \Carbon::now()->addDays(10)->format('Y-m-d');

        \App\Payment::where('date', $date)->whereHas('user', function ($query) {
            return $query->where('is_banned', 0)->where('is_approved', 1)->whereNotNull('email_verified_at');
        })->where('payment_status_id', '!=', \App\PaymentStatus::PAID)->get()->each(function ($payment) {
            if (!$payment->payment_url) { // si no tiene el link de pago, lo creo
                CreatePaymentLink::dispatchNow($payment);
            }

            $email = new PaymentButtonMail($payment);
            \Mail::to($payment->user)->queue($email);
        });
    }
}
