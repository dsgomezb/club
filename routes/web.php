<?php

//------------------------
//----------Test----------
//------------------------
Route::group(['namespace' => 'Test', 'prefix' => 'test', 'middleware' => 'test'], function() {
    Route::get('payments', function () {
        $payment = \App\Payment::whereNull('payment_url')->first();

        \App\Jobs\CreatePaymentLink::dispatchNow($payment);

        dd($payment->toArray());

        \App\Jobs\CreatePayments::dispatchNow();
    });

    Route::get('users/{user}/payments', function (\App\User $user) {
        dd($user->payments->toArray());
    });
});

//--------------------------
//----------Pagos----------
//--------------------------
Route::get('payments/success', 'Front\\PaymentController@success');
Route::get('payments/pending', 'Front\\PaymentController@pending');
Route::get('payments/failure', 'Front\\PaymentController@failure');
Route::get('webhooks/mercadopago', 'Front\\WebhooksController@mercadopago');
Route::post('webhooks/mercadopago', 'Front\\WebhooksController@mercadopago');

//--------------------------
//----------Perfil----------
//--------------------------
Route::group(['prefix' => 'perfil', 'middleware' => 'auth:user'], function() {
    Route::view('verificacion-pendiente', 'perfil.pending-verification')->name('verification.notice');
    Route::view('usuario-bloqueado', 'perfil.banned');
    Route::view('aprobacion-pendiente', 'perfil.pending-approval');

    Route::get("/", 'Front\\ProfileController@index')->middleware('restriction');
});

//-------------------------
//----------Admin----------
//-------------------------
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function() {
    //Redirec to admin default route
    Route::get('/', function () {
        return redirect(route('admin.home'));
    });

    Route::get('dashboard', 'DashboardController')->name('admin.home');

    Route::get('statistics/users', 'StatisticsController@users');
    /*
    Route::get('statistics/bestSellers', 'StatisticsController@bestSellers');
    Route::get('statistics/unpopulars', 'StatisticsController@unpopulars');
    Route::get('statistics/client', 'StatisticsController@client');
    Route::get('statistics/clientPurchases', 'StatisticsController@clientPurchases');
    */

    // Posts
    Route::get('posts/json', 'PostController@json');
    Route::resource('posts', 'PostController');

    // Comments
    Route::get('comments/json', 'CommentController@json');
    Route::resource('comments', 'CommentController');

    // Categories
    Route::get('categories/json', 'CategoryController@json');
    Route::resource('categories', 'CategoryController');

    // Users
    Route::get('users/json', 'UserController@json');
    Route::put('users/{user}/ban', 'UserController@ban');
    Route::put('users/{user}/unban', 'UserController@unban');
    Route::resource('users', 'UserController');

    // Admissions
    Route::get('admissions/json', 'AdmissionController@json');
    Route::put('admissions/{user}/approve', 'AdmissionController@approve');
    Route::put('admissions/{user}/disapprove', 'AdmissionController@disapprove');
    Route::resource('admissions', 'AdmissionController');

    // Payments
    Route::get('payments/{state}/json', 'PaymentController@json')->where('state', 'paid|pending|overdue');
    Route::get('payments/{state}', 'PaymentController@index')->where('state', 'paid|pending|overdue');
    Route::resource('payments', 'PaymentController');

    // Newsletter
    Route::get('newsletter/json', 'NewsletterController@json');
    Route::get('newsletter/export', 'NewsletterController@export');
    Route::resource('newsletter', 'NewsletterController');

    //manejo de imagenes
    Route::patch('images/{image}', 'ImageController@update');
    Route::post('images/upload', 'ImageController@upload');
    Route::post('video/upload', 'ImageController@uploadVideo');
    Route::post('images/{image}/delete', 'ImageController@destroy');
});

//-------------------------
//----------Front----------
//-------------------------
Route::group(['namespace' => 'Front', 'middleware' => ['auth:user', 'verified', 'restriction']], function() {
    //Home
    Route::get('/', 'HomeController');

    //Contacto
    Route::get('contacto', 'ContactController@show');
    Route::post('contact', 'ContactController@contact');
    Route::post('business-contact/{post}', 'ContactController@businessContact');


    //Busqueda
    Route::get('busqueda', 'PostController@search');

    //Newsletter
    Route::post('newsletter', 'NewsletterController@store');

    //Businesses
    Route::get('negocios', 'BusinessesController@index');
    Route::get('negocios/{slug}', 'BusinessesController@show');
    Route::post('perfil/negocios/create', 'BusinessesController@store')->name('businesses.create');
    Route::put('perfil/negocios/{post}/edit', 'BusinessesController@update')->name('businesses.edit');

    // Perfil
    Route::get('perfil/edit', 'ProfileController@editProfile')->name('profile.edit');
    Route::post('perfil/edit', 'ProfileController@updateProfile')->name('profile.update');
    
    //Usuarios
    Route::get('perfil/{username}', 'UserController@show');

    //Post
    Route::get('perfil/post/create', 'PostController@create')->name('post.create');
    Route::post('perfil/post/create', 'PostController@store');
    Route::get('perfil/post/{post}/edit', 'PostController@edit')->name('post.edit');
    Route::put('perfil/post/{post}/edit', 'PostController@update');
    Route::delete('perfil/post/{post}', 'PostController@destroy')->name('post.delete');
    Route::get('publicaciones/{month}/{year}', 'CategoryController@months')->where('year', '[0-9]{4}');
    Route::get('publicaciones/{day}/{month}/{year}', 'CategoryController@day')->where('year', '[0-9]{4}');

    Route::get('{categroy}/{slug}', 'PostController@show');
    Route::get('{categroy}', 'CategoryController@index');

    // calificar post
    Route::post('calificar/{post}', 'PostController@qualify');
});

Route::get('test1', 'RegisterController@test');
