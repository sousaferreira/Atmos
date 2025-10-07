<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\WeatherNewsController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\AuraController;

// Página principal da Cloudinha
Route::get('/cloudinha', function () {
    return view('aura'); // mantém a mesma view
})->name('IA.cloudinha');

// Rota para o chat da Cloudinha (requisições AJAX)
Route::post('/cloudinha', [AuraController::class, 'chat']);

Route::get('/comparar', [CompareController::class, 'index'])->name('compare.index');;


Route::get('/api/weather', [WeatherController::class, 'apiWeather'])->name('api.weather');


// Dashboard completo (gauges + histórico + tabela)
Route::get('/', [SensorDataController::class, 'show'])->name('sensor.dashboard');

Route::get('/sobre', [SensorDataController::class, 'sobre'])->name('sensor.sobre');


Route::get('/sensor-gauges-only', [SensorDataController::class, 'gauges'])->name('sensor.gauges');

// Histórico apenas
Route::get('/sensor-historico-only', [SensorDataController::class, 'historico'])->name('sensor.historico');

// JSON para histórico filtrado
Route::get('/sensor-historico-json', [SensorDataController::class, 'jsonHistorico']);

// Tabela apenas
Route::get('/sensor-tabela-only', [SensorDataController::class, 'tabela'])->name('sensor.tabela');

// JSON para gauges
Route::get('/sensor-data-json', [SensorDataController::class, 'getLatestData']);

// Notícias do clima
Route::get('/noticias-clima', [WeatherNewsController::class, 'index'])->name('weather.news');

Route::get('/weather-map', function () {
    return view('weather.weather-map');
})->name('weather.map');


Route::get('/api/weather-click', function(\Illuminate\Http\Request $request) {
    $lat = $request->query('lat');
    $lon = $request->query('lon');
    $apiKey = env('OPENWEATHER_API_KEY');

    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'lat' => $lat,
        'lon' => $lon,
        'units' => 'metric',
        'lang' => 'pt_br',
        'appid' => $apiKey
    ]);

    return $response->json();
});


