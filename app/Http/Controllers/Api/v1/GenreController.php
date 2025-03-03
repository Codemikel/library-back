<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Book;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mostLendedBooksByGenre = Genre::with(['books' => function ($query) {
            $query->withCount('loans')->orderByDesc('loans_count');
        }])->get()
        ->map(function ($genre) {
            return [
                'id' => $genre->id,
                'name' => $genre->name,
                'most_lended_book' => optional($genre->books->first())->name,
            ];
        });

        return response()->json($mostLendedBooksByGenre, 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        return Genre::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'name' => 'string|required'
        ]);

        $genre->update($request->all());
        return $genre;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genre = Genre::findOrFail($id);

        $genre->delete();

        return response()->json(['message' => 'Género eliminado correctamente'], 200);
    }
}
