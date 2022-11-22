<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherApi
{
    protected $baseUrl = 'https://api.openweathermap.org/data/2.5/';

    protected $city;
    protected $api;
    public  function __construct($api, $city)
    {
        $this->api = $api;

        $this->city = $city;
    }

    public  function currentWeather()
    {
        //https://api.openweathermap.org/data/2.5/weather
        $response = Http::baseUrl($this->baseUrl)->get('weather', [
            'q' => $this->city,
            'appid' => $this->api,
            'units' => 'metric',
            'lang' => 'ar'
        ])->json();
        return  $response;
    }
}