<?php

namespace App\Providers;

use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use App\SocialNetwork\Infrastructure\Repositories\PdoUserRepository;
use Illuminate\Support\ServiceProvider;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PDO::class, static function () {
            $dbConfig = config('database.connections.pgsql');
            return new PDO(
                "pgsql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['database']}",
                $dbConfig['username'],
                $dbConfig['password'],
            );
        });

        $this->app->bind(UserRepositoryInterface::class, PdoUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
