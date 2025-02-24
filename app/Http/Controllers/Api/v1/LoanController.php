<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Loan::with(['book', 'user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after:loan_date',
        ]);

        // Verificar si el book está available
        $book = Book::findOrFail($request->book_id);
        if (!$book->available) {
            return response()->json(['error' => 'El libro no está available'], 400);
        }


        $loan = Loan::create($request->all());


        $book->update(['available' => false]);

        return $loan;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Loan::with(['book', 'user'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $loan = Loan::findOrFail($id);

        $request->validate([
            'return_date' => 'nullable|date|after:loan_date',
            'returned' => 'boolean',
        ]);

        if ($request->has('returned') && $request->returned) {
            $loan->book->update(['available' => true]);
        }

        $loan->update($request->all());
        return $loan;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();
        return response()->noContent();
    }
}
