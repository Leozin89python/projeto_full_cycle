<?php

namespace App\Providers;

use GuzzleHttp\Client;
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
        $base_url = env('API_GATEWAY_BASE_URL');

        $this->app->singleton('GuzzleHttp\Client', function ($api) use ($base_url){
            return new Client([
                'base_uri' => $base_url,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => env('API_GATEWAY_KEY'),
                ]
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
