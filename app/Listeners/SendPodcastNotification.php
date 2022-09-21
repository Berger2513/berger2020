<?php

namespace App\Listeners;

use App\Events\PodcastProcessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPodcastNotification
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
     * @param  PodcastProcessed  $event
     * @return void
     */
    public function handle(PodcastProcessed $event)
    {
        $user = $event->user;

        \Log::info('123456');
    }
}
