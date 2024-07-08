<?php

namespace App\Services\GetWeatherService;

use App\Models\WeatherData;
use App\Services\GetWeatherService\Exceptions\InvalidApiKey;
use App\Services\GetWeatherService\Exceptions\InvalidCoordinates;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    const WEATHER_BASE = 'http://api.openweathermap.org/data/2.5/%s';
    const GET_WEATHER = 'weather?lat=%s&lon=%s&units=%s&appid=%s';
    const DEFAULT_UNITS = 'metric';

    public function makeWeatherRecord(?string $lat = null, ?string $lon = null): void
    {
        list($lat, $lon) = $this->resolveCoordinates($lat, $lon);
        $apiKey = $this->getApiKey();

        $weatherResponse = $this->getWeather($lat, $lon, $apiKey);

        if(!$weatherResponse->successful()){
            Log::warning($weatherResponse->body());

            return;
        }

        $weatherData = new WeatherData();
        $weatherData->fill([
            'temperature' => $weatherResponse->collect('main')->get('temp'),
        ]);
        $weatherData->save();
    }

    public function __invoke(): void
    {
        $weatherService = new self();

        $weatherService->makeWeatherRecord();
    }

    private function getWeather(string $lat, string $lon, string $apiKey): Response
    {
        $url = sprintf(self::WEATHER_BASE, self::GET_WEATHER);
        $url = sprintf($url, $lat, $lon, self::DEFAULT_UNITS, $apiKey);

        return Http::get($url);
    }

    private function resolveCoordinates(?string $lat, ?string $lon): array
    {
        $lat = $lat ?: env('DEFAULT_CITY_LAT', false);
        $lon = $lon ?: env('DEFAULT_CITY_LON', false);

        throw_if(
            $lat === false,
            new InvalidCoordinates('Latitude')
        );

        throw_if(
            $lon === false,
            new InvalidCoordinates('Longitude')
        );

        return [$lat, $lon];
    }

    private function getApiKey(): string
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY', false);

        throw_if(
            $apiKey === false,
            new InvalidApiKey()
        );

        return $apiKey;
    }
}
