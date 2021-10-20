<?php

namespace App\Http\Controllers\Front;

use App\Classes\KameImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;

class PostController extends Controller
{
    public function create()
    {
        $categories = \App\Category::orderBy('value')->where('id', '>', 1)->get();

        $post = new Post;

        return view('perfil.post.form', compact('categories', 'post'));
    }

    public function store(PostRequest $request)
    {
        $post = \Auth('user')
            ->user()
            ->posts()
            ->create(request()->only('title', 'content', 'category_id') + ['published_at' => date('Y-m-d h:i:s')])
        ;

        dispatch(function () use ($post) {
            KameImage::uploadPreviews($post);
            \Cache::flush();
        });

        return back()->with('message', ['type' => 'success', 'content' => 'La nueva entrada se creó con éxito']);
    }

    public function edit($post)
    {
        $post = Post::where('slug', $post)->firstOrFail();

        if ($post->user_id != \Auth('user')->id()) return redirect('/');

        $categories = \App\Category::orderBy('value')->where('id', '>', 1)->get();

        return view('perfil.post.edit', compact('categories', 'post'));
    }

    public function update($post, PostRequest $request)
    {
        $post = Post::where('slug', $post)->firstOrFail();

        if ($post->user_id != \Auth('user')->id()) return redirect('/');

        $post->update(request()->only('title', 'content', 'category_id'));

        dispatch(function () use ($post) {
            KameImage::uploadPreviews($post);
            \Cache::flush();
        });

        return redirect('perfil/post/' . $post->slug . '/edit')->with('message', ['type' => 'success', 'content' => 'La entrada se editó con éxito']);
    }

    public function show($categroy, $slug)
    {
        $categroy = \App\Category::where('slug', $categroy)->firstOrFail();

        $post = $this->getPost($slug);

        return view('front.posts.home.index', compact('post'));
    }

    private function getPost($slug)
    {
        $post = Post::with('category', 'author', 'images')
            ->with(['comments' => function ($query) {
                $query->with('commenter')->latest();
            }])
            ->where('slug', $slug)
            ->firstOrFail()
        ;

        $post->increment('views');

        return $post;
    }

    public function search()
    {
        $posts = \App\Post::advancedSearch(request()->input('q'), ['title', 'content', 'categories.value'], function($search) {
                $search->leftUnite('category')->latest('published_at');
            })
            ->where('is_visible', 1)
            ->paginate(12)
        ;

        return view('front.home.index', compact('posts'));
    }

    public function qualify(Post $post)
    {
        if (!$post->getAuthQualification()) {
            $calification = \App\Calification::create([
                'stars' => request()->input('stars'),
                'author_id' => auth('user')->id(),
                'post_id' => $post->id
            ]);

            $post->author->updateRanking();
        }

        return ['success'=>true];
    }

    public function destroy($post)
    {
        $post = Post::where('slug', $post)->firstOrFail();

        if ($post->user_id != \Auth('user')->id()) return redirect('/');

        $post->delete();

        return redirect('perfil')->with('message', ['type' => 'success', 'content' => 'La publicación fue eliminada.']);
    }
}
