<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

use App\TypiCode\CommentsAPI;
use App\TypiCode\PostsAPI;

class DataSourceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommentsAPI::class, function ($app) {
            return new CommentsAPI('https://jsonplaceholder.typicode.com');
        });

        $this->app->singleton(PostsAPI::class, function ($app) {
            return new PostsAPI('https://jsonplaceholder.typicode.com');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            CommentsAPI::class,
            PostsAPI::class,
        ];
    }
}
