<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $default = [
            'price' => \App\Plan::first()->price,
            'date' => Carbon::now()->addMonthNoOverflow()->format('Y-m-d'),
            'created_at' => date('Y-m-m H:i:s')
        ];

        $data = \App\Payment::where('date', date('Y-m-d'))->whereHas('user', function ($query) {
            return $query->where('is_banned', 0)->where('is_approved', 1)->whereNotNull('email_verified_at');
        })->get()->map(function ($payment) use ($default) {
            return [
                'user_id' => $payment->user_id,
                'price' => $default['price'],
                'date' => $default['date'],
                'created_at' => $default['created_at'],
                'updated_at' => $default['created_at'],
            ];
        });

        \DB::table('payments')->insert($data->toArray());
    }
}
