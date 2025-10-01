<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    // ---------------------------
    // Método para busca por cidade
    // ---------------------------
    public function index(Request $request)
    {
        $city = $request->get('city', '');
        $weather = [];

        if($city){
            $res = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'units' => 'metric',
                'lang' => 'pt_br',
                'appid' => $this->apiKey
            ]);

            $weather = $res->json();
        }

        return view('weather.index', compact('city', 'weather'));
    }

    // ---------------------------
    // Método para previsão por estado (JSON)
    // ---------------------------
    public function previsao($estado)
    {
        $coordenadas = [
            'ceara' => ['lat' => -5.4984, 'lon' => -39.3206],
            'sp' => ['lat' => -23.5505, 'lon' => -46.6333],
            'rj' => ['lat' => -22.9068, 'lon' => -43.1729],
            'mg' => ['lat' => -19.9208, 'lon' => -43.9378],
            'ba' => ['lat' => -12.9714, 'lon' => -38.5014],
            'rs' => ['lat' => -30.0346, 'lon' => -51.2177],
        ];

        if(!isset($coordenadas[$estado])){
            return response()->json(['erro' => 'Estado não encontrado'], 404);
        }

        $lat = $coordenadas[$estado]['lat'];
        $lon = $coordenadas[$estado]['lon'];

        $res = Http::get("https://api.openweathermap.org/data/3.0/onecall", [
            'lat' => $lat,
            'lon' => $lon,
            'exclude' => 'minutely,hourly,alerts',
            'units' => 'metric',
            'lang' => 'pt_br',
            'appid' => $this->apiKey
        ]);

        if(!$res->successful()){
            return response()->json(['erro' => 'Erro ao consultar API'], 500);
        }

        return $res->json();
    }
    public function apiWeather(Request $request)
{
    $city = $request->get('city');
    if (!$city) {
        return response()->json(['error' => 'city is required'], 400);
    }

    // 1) pega coordenadas da cidade
    $res = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'q' => $city,
        'units' => 'metric',
        'lang' => 'pt_br',
        'appid' => $this->apiKey
    ]);

    if (!$res->successful()) {
        return response()->json(['error' => 'Erro ao consultar OpenWeather (city)'], 500);
    }

    $coord = $res->json()['coord'] ?? null;
    if (!$coord || !isset($coord['lat']) || !isset($coord['lon'])) {
        return response()->json(['error' => 'Coordenadas não encontradas'], 500);
    }

    // 2) chama OneCall para a previsão (diária)
    $one = Http::get("https://api.openweathermap.org/data/3.0/onecall", [
        'lat' => $coord['lat'],
        'lon' => $coord['lon'],
        'exclude' => 'minutely,hourly,alerts',
        'units' => 'metric',
        'lang' => 'pt_br',
        'appid' => $this->apiKey
    ]);

    if (!$one->successful()) {
        return response()->json(['error' => 'Erro ao consultar OpenWeather (onecall)'], 500);
    }

    return response()->json($one->json());
}


}
