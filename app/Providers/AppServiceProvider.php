<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;

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

     Scramble::configure()
        ->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });
        
        // Register Laravel Passport routes
        \Laravel\Passport\Passport::enablePasswordGrant();
        
        // Configure Passport token lifetimes (optional)
        \Laravel\Passport\Passport::tokensExpireIn(now()->addDays(15));
        \Laravel\Passport\Passport::refreshTokensExpireIn(now()->addDays(30));
        \Laravel\Passport\Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
