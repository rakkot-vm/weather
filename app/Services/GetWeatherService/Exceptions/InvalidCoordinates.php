<?php

namespace App\Services\GetWeatherService\Exceptions;

class InvalidCoordinates extends \RuntimeException
{
    const DEFAULT_MESSAGE = 'Coordinates were not define';
    const EXACT_MESSAGE = 'Coordinates %s was not define';

    public function __construct(?string $message = null)
    {
        if ($message !== null) {
            $message = sprintf(self::EXACT_MESSAGE, $message);
        }else{
            $message = self::DEFAULT_MESSAGE;
        }

        parent::__construct($message);
    }
}
