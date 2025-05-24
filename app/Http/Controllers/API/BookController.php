<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'publish_date' => 'required|date|',
        ]);

        $book = Book::create($validated);

        return response()->json([
            "message" => "Book added.",
            'data' => $book
        ], 201);
    }

    public function show($id)
    {
        try {
            $book = Book::findOrFail($id);
            return response()->json($book);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update($request->only(['title', 'author', 'publish_date']));
            
            return response()->json([
                "message" => "Book updated"
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    }

    public function destroy($id) 
    {
        try {
            Book::findOrFail($id)->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }
}
