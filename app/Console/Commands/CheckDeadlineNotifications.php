<?php

namespace App\Console\Commands;

use App\Models\ContentBrief;
use App\Models\User;
use App\Notifications\DeadlineTaskNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckDeadlineNotifications extends Command
{
    protected $signature = 'notifications:check-deadlines';
    protected $description = 'Check and send deadline notifications for tasks';

    public function handle()
    {
        $this->info('Checking deadline notifications...');

        $today = Carbon::today();
        $twoDaysFromNow = (clone $today)->addDays(2)->endOfDay();

        // Get tasks with deadlines in the next 2 days or overdue
        $tasks = ContentBrief::whereNotNull('production_deadline')
            ->where(function ($query) use ($today, $twoDaysFromNow) {
                $query->where('production_deadline', '<=', $twoDaysFromNow);
            })
            ->with('brand')
            ->get();

        $notificationsSent = 0;

        foreach ($tasks as $task) {
            $daysLeft = $today->diffInDays($task->production_deadline, false);
            
            if ($task->production_deadline->isPast()) {
                // Overdue deadline
                $this->sendNotification($task, 'overdue', null);
                $notificationsSent++;
            } elseif ($daysLeft <= 2) {
                // Approaching deadline (2 days or less)
                $this->sendNotification($task, 'approaching', $daysLeft);
                $notificationsSent++;
            }
        }

        $this->info("Sent {$notificationsSent} deadline notifications");
        Log::info("Deadline check completed. Sent {$notificationsSent} notifications.");
    }

    private function sendNotification($task, $status, $daysLeft)
    {
        // Notify task creator
        $task->user->notify(new DeadlineTaskNotification($task, $status, $daysLeft));

        // Notify all admin users
        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($adminUsers as $admin) {
            $admin->notify(new DeadlineTaskNotification($task, $status, $daysLeft));
        }
    }
}
