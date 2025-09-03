<?php

namespace App\Providers;

use App\Events\WelcomeBack;
use App\Events\WelcomeRegisteration;
use App\Listeners\SendWelcomeBackNotification;
use App\Listeners\SendWelcomeNotification;
use App\Models\Book;
use App\Models\Category;
use App\Observers\BookObserver;
use App\Observers\CategoryObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Event::listen(
            WelcomeRegisteration::class,
            [SendWelcomeNotification::class, 'handle']
        );

        Event::listen(
            WelcomeBack::class,
            [SendWelcomeBackNotification::class, 'handle']
        );


        Book::observe(BookObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
