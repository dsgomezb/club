<?php

namespace App\Providers;

use App\Classes\Auth;
use Illuminate\Support\ServiceProvider;

class AuthRoutesServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Auth::routes();
    }
}
