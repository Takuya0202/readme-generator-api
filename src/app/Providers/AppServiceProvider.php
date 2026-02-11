<?php

namespace App\Providers;

use App\Contexts\Auth\Domain\Repository\UserRepository;
use App\Contexts\Auth\Infrastructure\Repository\EloquentUserRepository;
use App\Contexts\Index\Domain\Repository\ProjectRepository;
use App\Contexts\Index\Infrastructure\Repository\EloquentProjectRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use App\Models\PersonalAccessToken;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // ここでuserRepositoryで定義したメソッドを実装したクラスを注入している
    public function register(): void
    {
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            ProjectRepository::class,
            EloquentProjectRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
