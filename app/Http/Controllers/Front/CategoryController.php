<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Classes\Calendar;
use App\Http\Controllers\Controller;
use App\Post;
use Carbon\Carbon;

class CategoryController extends Controller
{
    public function index($category)
    {
        $category = Category::where('slug', $category)->firstOrFail();

        $posts = Post::with('category', 'images')
            ->where('category_id', $category->id)
            ->where('is_visible', 1)
            ->latest('published_at')
            ->limit(9)
            ->get()
        ;

        return view('front.home.index', compact('posts'));
    }

    public function businesses()
    {
        $posts = Post::with('category', 'images')
            ->where('category_id', Category::BUSINESSES)
            ->where('is_visible', 1)
            ->latest('published_at')
            ->limit(9)
            ->get()
        ;

        return view('front.negocios.index', compact('posts'));
    }

    public function months($month, $year, Calendar $calendar)
    {
        $month = array_search(ucfirst($month), $calendar->months);

        $start = Carbon::create($year, $month, 1);
        $end = $start->copy()->endOfMonth();

        $posts = Post::with('category', 'images')
            ->whereBetween('published_at', [$start, $end])
            ->where('is_visible', 1)
            ->latest('published_at')
            ->limit(9)
            ->get()
        ;

        return view('front.home.index', compact('posts'));
    }

    public function day($day, $month, $year)
    {
        $start = Carbon::create($year, $month, $day)->startOfDay();
        $end = $start->copy()->addDay();

        $posts = Post::with('category', 'images')
            ->whereBetween('published_at', [$start, $end])
            ->where('is_visible', 1)
            ->latest('published_at')
            ->limit(9)
            ->get()
        ;

        return view('front.home.index', compact('posts'));
    }

}
