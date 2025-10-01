<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherNewsController extends Controller
{
    public function index()
    {
        $apiKey = env('NEWS_API_KEY');

        // Palavras-chave para busca precisa
        $query = '"previsão do tempo" OR "queimadas" OR "climaticas"';

        // Chamada à NewsAPI
        $response = Http::get("https://newsapi.org/v2/everything", [
            'q' => $query,
            'language' => 'pt',
            'sortBy' => 'publishedAt',
            'pageSize' => 20, // aumenta um pouco para ter mais opções após o filtro
            'apiKey' => $apiKey,
            // opcional: limitar a fontes confiáveis
            // 'domains' => 'g1.globo.com,climatempo.com.br,inmet.gov.br',
        ]);

        $articles = $response->json()['articles'] ?? [];

        // Filtro adicional para garantir relevância
        $keywords = ['previsão', 'chuva', 'meteorologia', 'clima'];

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
