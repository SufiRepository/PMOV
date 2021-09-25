<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiringImplementationPlanNotification extends Notification
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
        $this->implementationplans = $params;
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

        $message = (new MailMessage)->markdown('notifications.markdown.report-expiring-implementationplans',
            [
                'implementationplans'  => $this->implementationplans,
                'threshold'  => $this->threshold,
            ])
            ->subject(trans('mail.Expiring_implementationplans_Report'));

        return $message;


    }

}
