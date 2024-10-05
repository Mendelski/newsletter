<?php

namespace App\Console\Commands;

use App\Models\Topic;
use App\Models\User;
use App\Notifications\TopicFollowedNotification;
use Illuminate\Console\Command;


class SendTestEmail extends Command
{
    protected $signature = 'email:send-test';

    protected $description = 'Send a test email for topic followed';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $user = User::where('email', 'niyoyo5437@skrank.com')->first();
        $topic = Topic::all()->first();

        if ($user && $topic) {
            $user->notify(new TopicFollowedNotification($topic));

            $this->info('Test email sent successfully!');
        } else {
            $this->error('User or Topic not found.');
        }
    }
}
