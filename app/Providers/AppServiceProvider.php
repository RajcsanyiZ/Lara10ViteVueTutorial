<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'locale' => function () {
                return app()->getLocale();
            },
            'language' => function () {
                if(!file_exists(resource_path('lang/'. app()->getLocale()
                    .'/'.app()->getLocale() .'.json'))) {
                    return [];
                }
                return json_decode(file_get_contents(
                        resource_path('lang/'.app()->getLocale() .'/'
                            .app()->getLocale() .'.json'))
                    , true);
            },
        ]);
    }
}
