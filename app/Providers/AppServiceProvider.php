<?php

namespace App\Providers;

use App\Http\Resources\ProductResource;
use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(env('API_KEY_CURRENCY'));
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
        // $locale = request('locale', Cookie::get('locale', config('locale')));
        // App::setlocale(request('locale', config('locale')));
        // Cookie::queue('locale', $locale, 60 * 24 * 365);
        ProductResource::withoutWrapping();

        Validator::extend('filter', function ($attribute, $value, $params) {
            return !in_array(strtolower($value), $params);
        }, 'The value is prohipted!');

        Paginator::useBootstrapFour();
        //Paginator::defaultView('pagination.custom');
    }
}