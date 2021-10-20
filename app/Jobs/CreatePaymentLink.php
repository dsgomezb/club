<?php

namespace App\Jobs;

use App\Classes\MercadoPago;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePaymentLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        $mercadoPago = new MercadoPago($this->payment);

        $this->payment->update([
            'payment_id' => $mercadoPago->getId(),
            'payment_url' => $mercadoPago->getInitPoint()
        ]);
    }
}
