<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Comment;
use App\Helpers\ObserverHelper;
use App\Observers\PostObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewsComposer\ActivityComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*', ActivityComposer::class);

        Post::observe(PostObserver::class);
        // Comment::observe(CommentObserver::class);
    }
}
