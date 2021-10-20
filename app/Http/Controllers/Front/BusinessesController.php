<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Classes\Calendar;
use App\Classes\KameImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRequest;
use App\Post;
use Carbon\Carbon;

class BusinessesController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'images')
            ->where('category_id', Category::BUSINESSES)
            ->where('is_visible', 1)
            ->latest('published_at')
            ->paginate(9)
        ;

        if (request()->ajax()) {
            $response = [
                'total'=> $posts->total(),
                'lastPage'=>$posts->lastPage(),
                'data'=> view('admin.components.iterator', ['view' => 'front.negocios._negocio', 'models' => $posts, 'model' => 'post'])->render(),
            ];
        } else {
            $response = view("front.negocios.index", compact('posts'));
        }

        return $response;
    }

    public function show($slug)
    {
        $post = Post::with('category', 'author', 'images')
            ->with(['comments' => function ($query) {
                $query->with('commenter')->latest();
            }])
            ->where('slug', $slug)
            ->firstOrFail()
        ;

        $post->increment('views');

        return view('front.posts.negocio.index', compact('post'));
    }

    public function store(BusinessRequest $request)
    {
        $post = \Auth('user')
            ->user()
            ->posts()
            ->create(request()->all() + ['published_at' => date('Y-m-d h:i:s'), 'category_id' => Category::BUSINESSES])
        ;

        dispatch(function () use ($post) {
            KameImage::uploadPreviews($post);
        });

        return back()->with('message', ['type' => 'success', 'content' => 'La nueva entrada se creó con éxito']);
    }

    public function update($post, BusinessRequest $request)
    {
        $post = Post::where('slug', $post)->firstOrFail();

        if ($post->user_id != \Auth('user')->id()) return redirect('/');

        $post->update(request()->all() + ['category_id' => Category::BUSINESSES]);

        dispatch(function () use ($post) {
            KameImage::uploadPreviews($post);
        });

        return redirect('perfil/post/' . $post->slug . '/edit')->with('message', ['type' => 'success', 'content' => 'La entrada se editó con éxito']);
    }
}
