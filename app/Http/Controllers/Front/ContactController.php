<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\BusinessContactMail;
use App\Mail\ContactMail;
use App\Post;

class ContactController extends Controller
{
    public function show()
    {
        return view('front.contact');
    }

    public function contact(ContactRequest $request)
    {
        $mail = new ContactMail(
            request()->input('message'),
            \Auth::guard('user')->user()
        );

        \Mail::queue($mail);

        return back()->with('message', ['type' => 'success', 'content' => 'El mensaje se envío con éxito']);
    }

    public function businessContact(Post $post, ContactRequest $request)
    {
        $mail = new BusinessContactMail(
            request()->input('message'),
            $post,
            \Auth::guard('user')->user()
        );

        \Mail::queue($mail);

        return back()->with('message', ['type' => 'success', 'content' => 'El mensaje se envío con éxito']);
    }
}
