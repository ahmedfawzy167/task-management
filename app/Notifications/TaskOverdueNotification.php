<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Task overdue: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('The task "' . $this->task->title . '" is now overdue.')
            ->line('Due date: ' . $this->task->due_date->format('Y-m-d H:i'))
            ->line('Please Review it as soon as possible.');
    }
}
