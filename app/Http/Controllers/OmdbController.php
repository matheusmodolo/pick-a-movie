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
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar filmes.', 'message' => $e->getMessage()], 500);
        }
    }
}
