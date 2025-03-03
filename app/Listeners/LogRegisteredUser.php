<?php

namespace App\Listeners;

use App\Models\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogRegisteredUser
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        Log::create([
            'description' => "New user registered: {$user->first_name} {$user->last_name} ({$user->email})",
            'type' => 'user',
        ]);
    }
}