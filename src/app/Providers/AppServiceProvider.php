<?php

namespace App\Providers;

use App\Contexts\Auth\Domain\Repository\UserRepository;
use App\Contexts\Auth\Infrastructure\Repository\EloquentUserRepository;
use App\Contexts\Project\Domain\Repository\ProjectRepository;
use App\Contexts\Project\Domain\Service\GenerateReadmeServiceInterface;
use App\Contexts\Project\Infrastructure\Repository\EloquentProjectRepository;
use App\Contexts\Project\Infrastructure\Service\GeminiReadmeGeneratorService;
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
        $this->app->bind(
            GenerateReadmeServiceInterface::class,
            GeminiReadmeGeneratorService::class,
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
