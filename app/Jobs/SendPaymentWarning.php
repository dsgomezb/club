<?php

namespace App\Jobs;

use App\Jobs\CreatePaymentLink;
use App\Mail\PaymentWarningMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentWarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        //se envía la advertencia pago 3 días antes del vencimiento

        $date = \Carbon::now()->addDays(3)->format('Y-m-d');

        \App\Payment::where('date', $date)->whereHas('user', function ($query) {
            return $query->where('is_banned', 0)->where('is_approved', 1)->whereNotNull('email_verified_at');
        })->where('payment_status_id', '!=', \App\PaymentStatus::PAID)->get()->each(function ($payment) {
            if (!$payment->payment_url) { // si no tiene el link de pago, lo creo
                CreatePaymentLink::dispatchNow($payment);
            }

            $email = new PaymentWarningMail($payment);
            \Mail::to($payment->user)->queue($email);
        });
    }
}
