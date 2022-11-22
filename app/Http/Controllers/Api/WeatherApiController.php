<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherApi;
use Illuminate\Http\Request;

class WeatherApiController extends Controller
{
    //
    public function weather()
    {
        $weather = new WeatherApi(config('services.weather.api_key'), 'Gaza');
        $response = $weather->currentWeather();
        dd($response);
    }
}