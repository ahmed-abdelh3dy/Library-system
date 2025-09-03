<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRequest;
use App\Jobs\ReturnBorrowedBook;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
        $borrow_books = Borrow::where('user_id', $user->id)->with('book')->paginate(10);

        return response()->json($borrow_books);
    }

    public function store(BorrowRequest $request)
    {


        $book = Book::find($request->book_id);

        if ($book->count <= 0 || $book->status === 'nonexist') {
            return response()->json([
                'message' => 'This book is not avilable.'
            ], 400);
        }

        $book->decrement('count');

        $borrow_a_book = Borrow::create([
            'user_id' => $request->user()->id,
            'book_id' => $request->book_id,
            'borrow_date' => now(),
            'return_date' => now()->addDays(7),
        ]);
        
        ReturnBorrowedBook::dispatch($borrow_a_book)->delay(now()->addDays(7));
        

        return response()->json($borrow_a_book, 201);

    }

    public function show(Request $request, Borrow $borrow)
    {
        $user = $request->user();

        if ($borrow->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden you dont have permission to do this action'], 403);
        }

        return response()->json($borrow);
    }

    public function update(Request $request, Borrow $borrow)
    {
        $user = $request->user();

        if ($borrow->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden you dont have permission to do this action'], 403);
        }

        $request->validate([
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $borrow->update($request->only(['return_date']));

        return response()->json([
            'status' => true,
            'message' => "You have successfully extended the borrow time for '{$borrow->book->title}'."
        ], 200);
    }

    public function destroy(Request $request, Borrow $borrow)
    {
        $user = $request->user();

        if ($borrow->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden you dont have permission to do this action'], 403);
        }

        $book = $borrow->book;
        if ($book) {
            $book->increment('count');
        }

        $borrow->delete();

        return response()->json([
            'status' => true,
            'message' => "You have successfully canceled this borrow. The book '{$borrow->book->title}' is back in the library."
        ], 200);
    }
}
