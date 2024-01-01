<?php

namespace App\Jobs;

use App\Notifications\CreateNewsEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // اطلاعات دریافت شده
    public $news;
    public $admin;
    /**
     * Create a new job instance.
     */
    public function __construct($news, $admin)
    {
        $this->news = $news;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Notification::send($this->admin, new CreateNewsEmail($this->news));
    }
}
