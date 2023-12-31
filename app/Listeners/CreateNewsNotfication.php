<?php

namespace App\Listeners;

use App\Models\News;
use App\Notifications\CreateNewNotfication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CreateNewsNotfication
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
    public function handle(object $event): void
    {
        // ست کردن یک نوتیفیکیشن
        Notification::send($event->users, new CreateNewNotfication($event->news));
    }
}
