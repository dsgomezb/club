<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppController;
use Laravelista\Comments\Comment;

class CommentController extends AppController
{
    protected $class = Comment::class;
    protected $viewFolder = 'admin.comments';
    protected $needAuthorization = false;
}
