<?php

namespace App\Providers;

use App\Author;
use App\Observers\AuthorObserver;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Author\AuthorRepositoryEloquent;
use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryEloquent;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(AuthorRepository::class,AuthorRepositoryEloquent::class);
        $this->app->singleton(BookRepository::class,BookRepositoryEloquent::class);
        $this->app->singleton(UserRepository::class,UserRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
