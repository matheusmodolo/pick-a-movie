<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\UserMovie;
use Illuminate\Http\Request;

class UserMovieController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $perPage = $request->query('per_page', 10);
        $page = $request->query('page', 1);

        // retorna registros do usuário incluindo detalhes do filme
        $list = UserMovie::with('movie')
            ->where('user_id', $user->id)
            ->orderBy('positions')
            ->paginate($perPage, ['*'], 'page', $page);

        // Retorna no formato esperado pelo frontend
        return response()->json([
            'data' => $list->items(),
            'meta' => [
                'current_page' => $list->currentPage(),
                'per_page' => $list->perPage(),
                'total' => $list->total(),
                'last_page' => $list->lastPage(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string',
            'Year' => 'required',
            'imdbID' => 'required|string',
            'Poster' => 'nullable|string'
        ]);

        $movie = Movie::where('imdb_id', $request->imdbID)->first();
        if (!$movie) {
            $movie = Movie::create([
                'imdb_id' => $request->imdbID,
                'title' => $request->Title,
                'year' => $request->Year,
                'poster' => $request->Poster,
            ]);
        }

        $user = $request->user();

        $lastPos = UserMovie::where('user_id', $user->id)->max('positions') ?? 0;
        $position = (int) $lastPos + 1;

        $entry = UserMovie::create([
            'user_id' => $user->id,
            'movie_id' => $movie->id,
            'positions' => $position,
            'rating' => $request->rating ?? null,
            'tags' => $request->tags ?? null,
        ]);

        // opcional: se quiser retornar também dados do OMDB, você poderia buscar aqui e anexar
        return response()->json($entry, 201);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $entry = UserMovie::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $entry->fill($request->only(['positions', 'rating', 'tags']));
        $entry->save();

        return response()->json($entry);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $entry = UserMovie::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $entry->delete();

        return response()->json(['success' => true]);
    }
}
