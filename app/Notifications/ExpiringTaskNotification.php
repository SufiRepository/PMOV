<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiringTaskNotification extends Notification
{
    use Queueable;
    /**
     * @var
     */
    private $params;

    /**
     * Create a new notification instance.
     *
     * @param $params
     */
    public function __construct($params, $threshold)
    {
        $this->tasks = $params;
        $this->threshold = $threshold;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via()
    {
        $notifyBy = [];
        $notifyBy[]='mail';
        return $notifyBy;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $asset
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {

        $message = (new MailMessage)->markdown('notifications.markdown.report-expiring-tasks',
            [
                'tasks'  => $this->tasks,
                'threshold'  => $this->threshold,
            ])
            ->subject(trans('mail.Expiring_Tasks_Report'));

        return $message;


    }

}
