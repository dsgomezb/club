<?php

namespace App\Classes;

//use Illuminate\Support\Str;

class Auth
{
    public static function routes()
    {
        $guards = config('auth.guards');

        foreach ($guards as $guard) {
            if ($guard['driver'] != 'session') continue;

            extract($guard);

            app()->router->middleware('web')
                ->prefix($prefix)
                ->namespace("App\Http\Controllers\Auth\\$namespace")
                ->name("$prefix.")
                ->group(function ($router) {
                    // Authentication Routes...
                    $router->get('login', 'LoginController@showLoginForm')->name('login');
                    $router->post('login', 'LoginController@login')->name('login');
                    $router->get('logout', 'LoginController@logout')->name('logout');

                    // Registration Routes...
                    $router->get('registro', 'RegisterController@showRegistrationForm')->name('register');
                    $router->post('registro', 'RegisterController@register')->name('register');

                    // Password Reset Routes...
                    $router->get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
                    $router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
                    $router->get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
                    $router->post('password/reset', 'ResetPasswordController@reset')->name('password.update');

                    // Email Verification
                    $router->get('email/verify', 'VerificationController@show')->name('verification.notice');
                    $router->get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
                    $router->post('email/resend', 'VerificationController@resend')->name('verification.resend');
                })
            ;
        }
    }
}
