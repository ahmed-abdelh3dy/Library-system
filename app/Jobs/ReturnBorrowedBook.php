<?php

namespace App\Jobs;

use App\Models\Borrow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ReturnBorrowedBook implements ShouldQueue
{
    use Queueable;


    public $borrowId;


    /**
     * Create a new job instance.
     */
    public function __construct($borrowId)
    {
        $this->borrowId = $borrowId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $borrow =  Borrow::find($this->borrowId);
        if (! $borrow){
            return;
        }

        $book =$borrow->book;    
        if ($book){
            $book->increment('count');
        }

        $borrow->delete();


    }
}
