<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Post;

class HomeController extends Controller
{
    public function __invoke()
    {
    	$posts = Post::with('category', 'images')
    		->where('category_id', '!=',\App\Category::BUSINESSES)
    		->where('is_visible', 1)
    		->latest('published_at')
    		->paginate(9)
    	;
        // dd($posts);

        if (request()->ajax()) {
            $response = [
                'total'=> $posts->total(),
                'lastPage'=>$posts->lastPage(),
                'data'=> view('admin.components.iterator', ['view' => 'front.home._card', 'models' => $posts, 'model' => 'post'])->render(),
            ];
        } else {
            $response = view("front.home.index", compact('posts'));
        }

    	return $response;
    }
}
