<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Payment;

class PaymentController extends Controller
{
    public function success()
    {
        $payment = Payment::where('payment_id', request()->input('preference_id'))->firstOrFail();

        if (in_array(env('APP_ENV'), ['local', 'env'])) {
            $payment->payment_status_id = \App\PaymentStatus::PAID;
            $payment->save();
        }

        return view('front.payments.success');
    }

    public function pending()
    {
        $payment = Payment::where('payment_id', request()->input('preference_id'))->firstOrFail();

        if (in_array(env('APP_ENV'), ['local', 'env'])) {
            $payment->payment_status_id = \App\PaymentStatus::PENDING;
            $payment->save();
        }

        return view('front.payments.pending');
    }

    public function failure()
    {
        $payment = Payment::where('payment_id', request()->input('preference_id'))->firstOrFail();

        if (in_array(env('APP_ENV'), ['local', 'env'])) {
            $payment->payment_status_id = \App\PaymentStatus::CANCELLED;
            $payment->save();
        }

        return view('front.payments.failure');
    }
}
