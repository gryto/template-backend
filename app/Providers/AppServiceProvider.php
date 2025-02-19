<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\\Http\\Controllers';  // Tambahkan namespace controller

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }

    // protected function mapApiRoutes()
    // {
    //     Route::prefix('api')
    //         ->middleware('api')
    //         ->namespace($this->namespace)
    //         ->group(base_path('routes/api.php'));
    // }

    public function boot()
    {
        $this->mapApiRoutes();  // Memastikan API routes sudah dipetakan
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));  // pastikan file api.php benar
    }
}
