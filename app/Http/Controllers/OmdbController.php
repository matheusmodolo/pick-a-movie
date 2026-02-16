<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OmdbController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('q');

        try {
            $response = Http::withoutVerifying()->get('https://www.omdbapi.com/', [
                'apikey' => config('services.omdb.key'),
                's' => $query,
                'type' => $request->query('type', 'movie'), // Filtrar por tipo (movie, series)
            ]);

            $responseData = $response->json();

            if (!isset($responseData['Search'])) {
                return response()->json(['error' => 'Nenhum resultado encontrado.'], 404);
            }
            foreach ($responseData['Search'] as &$item) {
                $posterUrl = $item['Poster'];
                $headers = get_headers($posterUrl);
                if (strpos($headers[0], '404') !== false) {
                    $item['Poster'] = 'https://placehold.co/200x300?text=No+Image'; // Substitua pela URL da imagem placeholder
                }
            }

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar filmes.', 'message' => $e->getMessage()], 500);
        }
    }

    public function details(Request $request, $id)
    {
        try {
            $response = Http::withoutVerifying()->get('https://www.omdbapi.com/', [
                'apikey' => config('services.omdb.key'),
                'i' => $id,
            ]);
            $responseData = $response->json();
            $posterUrl = $responseData['Poster'];
            $headers = get_headers($posterUrl);
            if (strpos($headers[0], '404') !== false) {
                $responseData['Poster'] = 'https://placehold.co/200x300?text=No+Image'; // Substitua pela URL da imagem placeholder
            }

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar detalhes do filme.', 'message' => $e->getMessage()], 500);
        }
    }
}
