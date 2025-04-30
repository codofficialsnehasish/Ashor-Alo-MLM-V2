<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Sanctum\Events\TokenCreated;
use Spatie\Activitylog\Facades\Activity as ActivityLogger;

class LogApiTokenCreated
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
    public function handle(TokenCreated $event)
    {
        ActivityLogger::causedBy($event->token->tokenable)
            ->withProperties([
                'token_name' => $event->token->name,
                'ip' => request()->ip(),
            ])
            ->log('API Token created successfully.');
    }
}
