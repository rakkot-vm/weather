<?php

namespace App\Services\GetWeatherService\Exceptions;

class InvalidApiKey extends \RuntimeException
{
    const DEFAULT_MESSAGE = 'Openweathermap api key was not define';

    public function __construct()
    {
        parent::__construct(self::DEFAULT_MESSAGE);
    }
}
