<?php

namespace App\Providers;

use App\Http\ViewComposers\FormComposer;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //front
        view()->composer('front/partials/_sidebar', function ($view) {
            $view->with('populars', $this->getPopulars());
            $view->with('months', $this->monthsAsCategory());
            $view->with('calendarData', $this->calendarData());
        });

        /*
        view()->composer('front/home/_sliders', function ($view) {
            $view->with('homeSliders', $this->getLatest());
        });
        */

        view()->composer('perfil/partials/_sidebar', function ($view) {
            $view->with('latestBusinesses', $this->getLatest(\App\Category::BUSINESSES));
        });

        //admin
        view()->composer('*kame-form*', FormComposer::class);

    }

    private function getLatest($categoryId=false)
    {
        return \App\Post::with('category', 'images')
            ->where('is_visible', 1)
            ->when($categoryId, function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest('published_at')
            ->limit(3)
            ->get()
        ;
    }

    private function getPopulars()
    {
        return \Cache::remember('getPopulars', 60*60*24, function () {
            return \App\Post::populars()->with('images', 'category')->where('category_id', '!=', \App\Category::BUSINESSES)->get();
        });
    }

    private function monthsAsCategory()
    {
        return \Cache::remember('monthsAsCategory', 60*60*24, function () {
            return \App\Post::selectRaw('COUNT(id) as total, MONTH(published_at) AS month, YEAR(published_at) as year')
                ->where('is_visible', 1)
                ->where('category_id', '!=', \App\Category::BUSINESSES)
                ->where('published_at', '>=', now()->subMonths(5))
                ->groupBy('month', 'year')
                ->orderBy('published_at', 'desc')
                ->get()
            ;
        });
    }

    public function calendarData()
    {
        return \Cache::rememberForever('calendarData', function () {
            return \App\Post::selectRaw('DATE(published_at) as date')
                ->where('is_visible', 1)
                ->where('published_at', '>', Carbon::now()->subYears(2))
                ->groupBy('date')
                ->get()
            ;
        });
    }

    public function register()
    {
        //
    }

}
