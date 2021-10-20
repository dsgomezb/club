<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsletterRequest;
use App\Newsletter;

class NewsletterController extends Controller
{
    public function store(NewsletterRequest $request)
    {
        Newsletter::create(request()->all());
    }
}
