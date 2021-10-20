<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = $user->posts()->limit(9)->orderBy('published_at', 'desc')->get();
        
        $posts->load(['images','category']);
        $user->load(['califications.post.category','califications.author']);
        
        return view('perfil.index', compact('user', 'posts'));
    }
}
