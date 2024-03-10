<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetNotification extends Notification
{
    use Queueable;
    public $subject;
    public $user;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($subject, $user, $message)
    {
        $this->subject = $subject;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject(Lang::get($this->subject))
        ->line(Lang::get('Dear '.$this->user->name))
        ->line(Lang::get($this->message))
        ->line(' ')
        ->line("Don't recognize this activity? Please contact developer for support immediately.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
