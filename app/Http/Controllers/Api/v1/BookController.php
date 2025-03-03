<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::with(['author', 'genre' => function ($query) {
            $query->whereNull('deleted_at');
        }])->whereHas('genre', function ($query) {
            $query->whereNull('deleted_at');
        })->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'genre_id' => 'required|exists:genres,id',
            'available' => 'boolean',
        ]);

        return Book::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Book::with(['author', 'genre'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'name' => 'string',
            'author_id' => 'exists:authors,id',
            'genre_id' => 'exists:genres,id',
            'available' => 'boolean',
        ]);

        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->noContent();
    }
}
