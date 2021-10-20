<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use App\Mail\BanNotification;
use App\User;

class UserController extends AppController
{
    protected $class = User::class;
    protected $viewFolder = 'admin.users';
    protected $needAuthorization = false;

    public function jsonQuery($query)
    {
        return $query->where('is_approved', 1)->whereNotNull('email_verified_at');
    }

    public function ban(User $user)
    {
    	$user->update(['is_banned' => 1]);

    	if (request()->input('send-message')) {
    		$email = new BanNotification(request()->input('message'));
    		\Mail::to($user)->queue($email);
    	}

    	return redirect($this->getPath() . '#ban');
    }

    public function unban(User $user)
    {
    	$user->update(['is_banned' => 0]);

    	return redirect($this->getPath() . '#unban');

    	// al próximo pago le voy sumando un mes hasta que sea mayor a hoy
    }
}
