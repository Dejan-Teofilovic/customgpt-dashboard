<?php

namespace App\Listeners;

use App\Events\MyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MyEventListener
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
     * @param  \App\Events\MyEvent  $event
     * @return void
     */
    public function handle(MyEvent $event)
    {
    }
}
