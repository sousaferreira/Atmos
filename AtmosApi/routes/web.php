<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SensorDataController;
use App\Http\Controllers\WeatherNewsController;
use App\Http\Controllers\WeatherController;

Route::get('/api/weather', [WeatherController::class, 'apiWeather'])->name('api.weather');



Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');

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

