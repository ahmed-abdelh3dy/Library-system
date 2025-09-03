<?php

namespace App\Observers;

use App\Jobs\SendNewBookEmail;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookObserver
{
    /**
     * Handle the Book "created" event.
     */
    public function created(Book $book): void
    {
        $users = User::all();

        foreach ($users as $user) {
            SendNewBookEmail::dispatch($book , $user);
        }
    }

    /**
     * Handle the Book "updated" event.
     */
    public function updateing(Book $book): void
    {
        $oldImage = $book->getOriginal('image');

        if ($book->isDirty('image') && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }
    }

    public function deleting(Book $book): void
    {
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
    }

    /**
     * Handle the Book "deleted" event.
     */
    public function deleted(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "restored" event.
     */
    public function restored(Book $book): void
    {
        //
    }

    /**
     * Handle the Book "force deleted" event.
     */
    public function forceDeleted(Book $book): void
    {
        //
    }
}
