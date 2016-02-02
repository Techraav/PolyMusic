<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\News;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $news = News::where('active', 1)->orderBy('id', 'desc')->limit(10)->get();
        // view()->share(compact('news'));
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
