<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Http\Controllers\AppController;

class PostController extends AppController
{
    protected $class = Post::class;
    protected $viewFolder = 'admin.posts';
    protected $needAuthorization = false;

    public function show($id)
    {
        $post = $this->class::find($id);

        return view ($this->viewFolder.".show", compact('post'));
    }

    protected function afterSave($model)
    {
        \Cache::flush();
    }

    protected function afterDelete()
    {
        \Cache::flush();
    }
}
