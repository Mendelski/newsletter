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
        // Check if the queue worker is running
        $workersRunning = shell_exec('ps aux | grep "queue:work" | grep -v "grep"');

        if (empty($workersRunning)) {
            $this->error('Queue worker is not running. Please run "./vendor/bin/sail artisan queue:work" before sending the email.');
            return;
        }

        $user = User::first();
        if(!$user){
            $this->info('User not found, creating a new one...');
            $user = User::factory()->create();
        }
        $topic = Topic::all()->first();

        if ($user && $topic) {
            $user->notify(new TopicFollowedNotification($topic));

            $this->info('Test email should be sent to ' . $user->email . 'successfully.');
        } else {
            $this->error('User or Topic not found.');
        }
    }
}
