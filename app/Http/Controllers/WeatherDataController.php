<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetDayWeatherDataRequest;
use App\Models\WeatherData;
use Carbon\Carbon;

class WeatherDataController extends Controller
{

    public function getByDay(GetDayWeatherDataRequest $request)
    {
        $temps = WeatherData::whereBetween('created_at', [
            $request->day,
            Carbon::create($request->day)->addDay()->format('Y-m-d')
        ])->get();

        return response()->json(['temperatures' => $temps]);
    }
}
