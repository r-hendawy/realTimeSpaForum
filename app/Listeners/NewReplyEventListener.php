<?php

namespace App\Listeners;

use App\Events\newReplyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class newReplyEventListener
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
     * @param  newReplyEvent  $event
     * @return void
     */
    public function handle(newReplyEvent $event)
    {
        //
    }
}
