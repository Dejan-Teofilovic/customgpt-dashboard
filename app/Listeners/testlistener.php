<?php

namespace App\Listeners;

use App\Events\testevent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class testlistener
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
     * @param  \App\Events\testevent  $event
     * @return void
     */
    public function handle(testevent $event)
    {
        //
    }
}
