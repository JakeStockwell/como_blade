<?php

namespace App\Listeners;

use App\Events\MotionCreated;
use App\Models\User;
use App\Notifications\NewMotion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMotionCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MotionCreated  $event
     * @return void
     */
    public function handle(MotionCreated $event)
    {
        foreach (User::whereNot('id', $event->motion->user_id)->cursor() as $user) {
            $user->notify(new NewMotion($event->motion));
        }
    }
}
