<?php

namespace App\Notifications;

use App\Models\Topic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TopicFollowedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected Topic $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject('Hey, what\'s up? We have a new post for you!')
            ->line("New post in topic you follow: {$this->topic->name}")
            ->line('Check it out in our website!');
    }
}
