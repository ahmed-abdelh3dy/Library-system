<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\True_;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user && $user->role === 'admin') {
            $books = Book::paginate(10);
        } else {
            $books = Book::where('status', 'exist')->paginate(10);
        }

        return response()->json($books, 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request, $categoryId)
    {

        $category = Category::find($categoryId);
        if (! $category) {
            return response()->json([
                'message' => 'Category not found. Cannot assign book to it.'
            ], 404);
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book = $category->books()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($categoryId, $bookId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $book = Book::find($bookId);
        if (!$book || $book->category_id !== $categoryId) {
            return response()->json([
                'message' => 'Book not exist in this category'
            ], 404);
        }

        return response()->json($book, 200);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category, Book $book)
    {
        $data = $request->all();


        $book = $category->books()->findOrFail($book->id);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return response()->json([
            'status' => True,
            'message' => 'book updated ',
            'book' => $book
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Category $category, Book $book)
    {
        $book = $category->books()->findOrFail($book->id);

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully'
        ], 200);
    }
}
