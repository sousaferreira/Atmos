<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherNewsController extends Controller
{
    public function index()
    {
        $apiKey = env('NEWS_API_KEY');

        // Requisição para notícias do Brasil em português
        $response = Http::get("https://newsapi.org/v2/top-headlines", [
            'country' => 'br',
            'language' => 'pt',
            'pageSize' => 20,
            'apiKey' => $apiKey,
        ]);

        // Pega os artigos
        $articles = $response->json()['articles'] ?? [];

        // Filtro básico (opcional)
        $keywords = ['previsão', 'chuva', 'meteorologia', 'clima', 'tempo', 'queimada'];
        $filteredNews = collect($articles)->filter(function ($article) use ($keywords) {
            foreach ($keywords as $word) {
                if (
                    (!empty($article['title']) && stripos($article['title'], $word) !== false) ||
                    (!empty($article['description']) && stripos($article['description'], $word) !== false)
                ) {
                    return true;
                }
            }
            return false;
        })->values()->all();

        return view('weather.news', ['news' => $filteredNews]);
    }
}
