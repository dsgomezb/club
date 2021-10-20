<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use App\Jobs\CreatePaymentLink;
use App\Jobs\SendApprovalMail;
use App\User;
use Carbon\Carbon;

class AdmissionController extends AppController
{
    protected $class = User::class;
    protected $viewFolder = 'admin.admissions';
    protected $needAuthorization = false;

    public function jsonQuery($query)
    {
        return $query->where('is_banned', 0)->where('is_approved', 0)->whereNotNull('email_verified_at');
    }

    public function approve(User $user)
    {
    	$user->update(['is_approved' => 1]);

        $payment = $this->createPayment($user);

        CreatePaymentLink::withChain([new SendApprovalMail($payment)])->dispatch($payment);

    	return redirect($this->getPath() . '#approve');
    }

    public function disapprove(User $user)
    {
        $user->forceDelete();

    	return redirect($this->getPath() . '#disapprove');
    }

    private function createPayment($user)
    {
        return \App\Payment::create([
            'date' => Carbon::now()->addDays(5),
            'price' => \App\Plan::first()->price,
            'user_id' => $user->id
        ]);
    }
}
