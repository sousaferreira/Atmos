<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\SensorData;


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

 public function comparacaoInmet()
    {
        // 1️⃣ Pega dados da estação
        $sensorData = SensorData::latest()->take(100)->get();

        // 2️⃣ Lê CSV INMET
        $inmetData = [];
        $csvFile = storage_path('app/inmet/inmet_data.csv');

        if(file_exists($csvFile)){
            $rows = array_map('str_getcsv', file($csvFile));
            $header = array_shift($rows);

            foreach($rows as $row){
                if(count($row) < count($header)) continue;

                $rowData = array_combine($header, $row);

                $datetime = Carbon::createFromFormat('d/m/Y H:i', $rowData['DATA'] . ' ' . $rowData['HORA']);

                // Arredonda timestamp para hora mais próxima
                $timestampKey = round($datetime->timestamp / 3600) * 3600;

                $inmetData[$timestampKey] = [
                    'TEMPERATURA' => floatval(str_replace(',', '.', $rowData['TEMPERATURA'] ?? 0)),
                    'UMIDADE' => floatval(str_replace(',', '.', $rowData['UMIDADE'] ?? 0)),
                    'VENTO' => floatval(str_replace(',', '.', $rowData['VENTO'] ?? 0)),
                    'DATETIME' => $datetime,
                ];
            }
        }

        // 3️⃣ Combina dados usando timestamp arredondado
        $comparacao = [];
        foreach($sensorData as $s){
            $timestampKey = round($s->created_at->timestamp / 3600) * 3600;

            $closest = $inmetData[$timestampKey] ?? null;

            $comparacao[] = [
                'created_at' => $s->created_at,
                'temp_atmos' => $s->temperature,
                'temp_inmet' => $closest['TEMPERATURA'] ?? null,
                'umidade_atmos' => $s->humidity,
                'umidade_inmet' => $closest['UMIDADE'] ?? null,
                'luminosity' => $s->luminosity,
                'rain' => $s->rain,
            ];
        }

        return view('comparacao-inmet', compact('comparacao'));
    }

}
