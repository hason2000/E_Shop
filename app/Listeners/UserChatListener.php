<?php

namespace App\Listeners;

use App\Events\UserChatEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserChatListener
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
     * @param  \App\Events\UserChatEvent  $event
     * @return void
     */
    public function handle(UserChatEvent $event)
    {
    }
}
