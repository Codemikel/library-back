<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount(['books' => function ($query) {
            $query->whereHas('genre', function ($query) {
                $query->whereNotNull('id')->whereNull('deleted_at');
            });
        }])->get()->map(function ($author) {
            return [
                'id' => $author->id,
                'name' => $author->name,
                'total_books' => $author->books_count,
            ];
        });

        return response()->json($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        return Author::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);

        $author->delete();

        return response()->json(['message' => 'Autor eliminado correctamente'], 200);
    }
}
