<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class KameCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //----------------------
        //-----Dependencies-----
        //----------------------

        //kameform
        $this->app->bind('kameform', 'App\Classes\KameForm');
    }
}
