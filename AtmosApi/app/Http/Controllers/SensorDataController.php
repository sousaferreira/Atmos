<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SensorDataController extends Controller
{
    // Recebe dados dos sensores (POST)
    public function store(Request $request)
    {
        $data = new SensorData();
        $data->luminosity  = $request->luminosity;
        $data->rain= $request->rain;
        $data->temperature = $request->temperature;
        $data->humidity    = $request->humidity;
        $data->save();

        return response()->json(['message' => 'Data saved successfully!']);
    }

    // Dashboard completo (gauges + histórico + tabela)
    public function show()
    {
        $sensorData = SensorData::orderBy('created_at', 'desc')->get();
        return view('dashboard', compact('sensorData'));
    }
     public function sobre()
    {
        $sensorData = SensorData::orderBy('created_at', 'desc')->get();
        return view('sensor_data', compact('sensorData'));
    }
 
 
    // Gauges apenas (último registro)
    public function gauges()
    {
        $sensorData = SensorData::latest()->take(1)->get();
        return view('sensor_data_gauges', compact('sensorData'));
    }

    // Histórico apenas (últimos 100 registros)
    public function historico()
    {
        $sensorData = SensorData::orderBy('created_at', 'desc')->take(100)->get();
        return view('historico', compact('sensorData'));
    }

    // Retorna dados JSON para histórico filtrado
    

public function jsonHistorico(Request $request)
{
    $date  = $request->input('date');  // yyyy-mm-dd
    $month = $request->input('month'); // mm
    $year  = $request->input('year');  // yyyy

    $query = DB::table('sensor_data')->orderBy('created_at', 'asc');

    if ($date) {
        // Filtro por dia
        $start = Carbon::createFromFormat('Y-m-d', $date, 'America/Sao_Paulo')->startOfDay();
        $end   = Carbon::createFromFormat('Y-m-d', $date, 'America/Sao_Paulo')->endOfDay();
        $query->whereBetween('created_at', [$start->setTimezone('UTC'), $end->setTimezone('UTC')]);
    } elseif ($month && $year) {
        // Filtro por mês
        $start = Carbon::createFromFormat('Y-m', "$year-$month", 'America/Sao_Paulo')->startOfMonth();
        $end   = $start->copy()->endOfMonth();
        $query->whereBetween('created_at', [$start->setTimezone('UTC'), $end->setTimezone('UTC')]);
    } elseif ($year) {
        // Filtro por ano
        $start = Carbon::createFromFormat('Y', $year, 'America/Sao_Paulo')->startOfYear();
        $end   = $start->copy()->endOfYear();
        $query->whereBetween('created_at', [$start->setTimezone('UTC'), $end->setTimezone('UTC')]);
    }

    $dados = $query->get();

    // Formata para o frontend
    $result = $dados->map(function($item){
        return [
            'hora' => Carbon::parse($item->created_at)->setTimezone('America/Sao_Paulo')->format('H:i'),
            'temperature' => $item->temperature,
            'humidity' => $item->humidity,
            'luminosity' => $item->luminosity,
            'rain' => $item->rain
        ];
    });

    return response()->json($result);
}



    // Tabela apenas (últimos 100 registros)
    public function tabela()
    {
        $sensorData = SensorData::latest()->take(100)->get();
        return view('sensor_data_tabela', compact('sensorData'));
    }

    // Último registro JSON (apenas para gauges)
    // No controller para JSON dos gauges
public function getLatestData()
{
    $data = SensorData::orderBy('id', 'desc')->first();
    return response()->json($data);
}

}
