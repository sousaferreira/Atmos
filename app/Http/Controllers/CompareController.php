<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\InmetData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $year = date('Y');

        // Mês do Sensor
        $monthSensor = $request->input('month_sensor', date('m'));
        $startSensor = Carbon::createFromFormat('Y-m', "$year-$monthSensor")->startOfMonth();
        $endSensor   = $startSensor->copy()->endOfMonth();
        $sensorData = SensorData::whereBetween('created_at', [$startSensor, $endSensor])->get();

        // Mês do INMET
        $monthInmet = $request->input('month_inmet', date('m'));
        $startInmet = Carbon::createFromFormat('Y-m', "$year-$monthInmet")->startOfMonth();
        $endInmet   = $startInmet->copy()->endOfMonth();
        $inmetData = InmetData::whereBetween('observed_at', [$startInmet, $endInmet])->get();

        return view('compare_day', compact('sensorData', 'inmetData', 'monthSensor', 'monthInmet'));
    }
}
