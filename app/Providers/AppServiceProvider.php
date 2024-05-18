<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory as RoutingResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
    public function boot(): void
    {
        RoutingResponseFactory::macro('api', function($data = null, $error = 0, $massage = '',int  $statusCode = 200){
            return response()->json([
                'data' => $data,
                'error' => $error,
                'massage' => $massage,
            ], $statusCode);
        });
    }
}
