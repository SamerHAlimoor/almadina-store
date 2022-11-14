<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psy\Readline\Hoa\Console;

class CurrencyConverter
{
    private $apiKey;

    protected $baseUrl = 'https://api.apilayer.com/currency_data';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function  convert(string $from, string $to, float $amount = 1): float
    {

        // /to=USD&from=ILS&amount=400
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'apikey' => $this->apiKey,
            'Content-Type' => 'text/plain',
        ])->get('/convert', [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ]);

        $result = $response->json();
        Log::info($result);
        // dd($result);
        return $result['result'] * $amount;
    }
}