<?php

namespace App\Providers;

use App\SocialNetwork\Domain\User\Repositories\UserRepositoryInterface;
use App\SocialNetwork\Infrastructure\PDOConnectionWrapper;
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
        $this->app->singleton(PDOConnectionWrapper::class, static function () {
            $dbConfig = config('database.connections.pgsql');

            $writeHost = $dbConfig['write']['host'][0];
            $readHost = $dbConfig['read']['host'][random_int(0, count($dbConfig['read']['host']) - 1)];
            return new PDOConnectionWrapper(
                writeConnection: new PDO(
                    "pgsql:host={$writeHost};port={$dbConfig['port']};dbname={$dbConfig['database']}",
                    $dbConfig['username'],
                    $dbConfig['password'],
                ),
                readConnection: new PDO(
                    "pgsql:host={$readHost};port={$dbConfig['port']};dbname={$dbConfig['database']}",
                    $dbConfig['username'],
                    $dbConfig['password'],
                ),
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
