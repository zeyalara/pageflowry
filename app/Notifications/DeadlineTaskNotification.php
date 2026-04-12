<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeadlineTaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $task,
        public $deadlineStatus, // 'approaching' or 'overdue'
        public $daysLeft = null
    ) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $message = $this->deadlineStatus === 'overdue' 
            ? "Tugas '{$this->task->title}' sudah melewati deadline"
            : "Tugas '{$this->task->title}' akan deadline dalam {$this->daysLeft} hari";

        return [
            'title' => $this->deadlineStatus === 'overdue' ? 'Deadline Terlewat' : 'Deadline Mendekati',
            'message' => $message,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'deadline' => $this->task->production_deadline->format('d M Y'),
            'deadline_status' => $this->deadlineStatus,
            'days_left' => $this->daysLeft,
            'type' => 'deadline_notification'
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->deadlineStatus === 'overdue' ? 'Deadline Terlewat' : 'Deadline Mendekati',
            'message' => $this->deadlineStatus === 'overdue' 
                ? "Tugas '{$this->task->title}' sudah melewati deadline"
                : "Tugas '{$this->task->title}' akan deadline dalam {$this->daysLeft} hari",
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'deadline' => $this->task->production_deadline->format('d M Y'),
            'deadline_status' => $this->deadlineStatus,
            'days_left' => $this->daysLeft,
            'type' => 'deadline_notification'
        ];
    }
}
