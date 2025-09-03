<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewBookEmail implements ShouldQueue
{
    use Queueable;

    public $book;
    public $user;


    /**
     * Create a new job instance.
     */
    public function __construct($book , $user)
    {
        $this->user = $user;
        $this->book = $book;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        Mail::raw("A New Book has arrived: {$this->book->title}", function ($message)  {
            $message->to($this->user->email)
                    ->subject("New Book {$this->book->title}");
        });
        
    }
}
