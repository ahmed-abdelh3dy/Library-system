<?php

namespace App\Listeners;

use App\Events\WelcomeRegisteration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WelcomeRegisteration $event): void
    {
        $user = $event->user;

        Mail::raw("welcome {$user->name}! Thank you for register", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Welcome to our Library!');
        });;
    }
}
