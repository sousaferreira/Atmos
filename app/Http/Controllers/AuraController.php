<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuraController extends Controller
{
    public function chat(Request $request)
    {
        $prompt = $request->input('prompt');

        // Requisição para a API da Cloudinha
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('MISTRAL_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.mistral.ai/v1/chat/completions', [
            'model' => 'mistral-small',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Você é Cloudinha, uma IA simpática e inteligente especialista em clima e meio ambiente. Você conhece o projeto AtmosTech, uma estação meteorológica que coleta dados de temperatura, umidade, luminosidade e chuva. Responda de forma breve, amigável e com emojis quando fizer sentido.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ],
            ],
        ]);

        return response()->json($response->json());
    }
}
