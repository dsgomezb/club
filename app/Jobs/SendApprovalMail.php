<?php

namespace App\Jobs;

use App\Mail\ApprovalNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendApprovalMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payment;

    public function __construct($payment)
    {
        $this->payment = $payment->fresh();
    }

    public function handle()
    {
        $email = new ApprovalNotification($this->payment->payment_url);
        
        \Mail::to($this->payment->user)->queue($email);
    }
}
