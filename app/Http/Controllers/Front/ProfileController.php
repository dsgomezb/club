<?php

namespace App\Http\Controllers\Front;

use App\Classes\KameImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        $user = \Auth('user')->user();
        $posts = $user->posts()->limit(9)->orderBy('published_at', 'desc')->get();
        
        $posts->load(['images','category']);
        $user->load(['califications.post.category','califications.author']);

        return view('perfil.index', compact('user', 'posts'));
    }

    public function editProfile()
    {
    	$user = \Auth('user')->user();
    	$posts = $user->posts()->orderBy('published_at', 'desc')->get();
        return view('perfil.editProfile', compact('user','posts'));
    }

    public function updateProfile(ProfileRequest $request)
    {
    	$user = \Auth('user')->user();
    	$user->fill(request()->only('firstname','lastname','about'));

    	// Image
        KameImage::uploadPreviews($user);

    	if (request()->has("password")) 
    		$user->password = \Hash::make(request()->input('password'));

    	$user->save();
    	return redirect('/perfil')->with('message',['type'=>'success','content'=>'Perfil actualizado correctamente']);
    }
}
