<?php

namespace App\Listeners;

use App\Events\WelcomeBack;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeBackNotification
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
    public function handle(WelcomeBack $event): void
    {

        $user = $event->user;

        Mail::raw("welcome back {$user->name }", function ($message) use ($user) {
            
            $message->to($user->email)->subject('Welcome Back');
            
        });
        
    }
}
