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

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New post in topic you follow')
            ->line("New post in topic you follow: {$this->topic->name}")
            ->action('View post', url('/'));

    }
}
