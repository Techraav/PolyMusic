<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\News;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $news = News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get();
        view()->share(compact('news'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
