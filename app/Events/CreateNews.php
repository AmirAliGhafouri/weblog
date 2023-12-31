<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateNews
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // خبری که نازه ایجاد شده
    public $news;

    // کاربرانی که قراره براشون نوتفیکیشن ارسال بشه
    public $users;
        
    /**
     * Create a new event instance.
     */
    public function __construct($news, $users)
    {
        $this->news = $news;
        $this->users = $users;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
