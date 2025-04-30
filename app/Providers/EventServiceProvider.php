<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Laravel\Sanctum\Events\TokenCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\Activitylog\Facades\LogBatch;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            \App\Listeners\LogSuccessfulLogin::class,
        ],
        Logout::class => [
            \App\Listeners\LogSuccessfulLogout::class,
        ],
        Failed::class => [
            \App\Listeners\LogFailedLogin::class,
        ],
        TokenCreated::class => [
            \App\Listeners\LogApiTokenCreated::class,
        ],
    ];

    public function register(): void
    {
        //
    }
}
