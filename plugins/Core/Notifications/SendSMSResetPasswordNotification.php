<?php

namespace Labs\Core\Notifications;

use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

/**
 * Class SendSMSResetPasswordNotification
 * @package Labs\Core\Notifications
 */
class SendSMSResetPasswordNotification extends Notification
{
    /**
     * @var
     */
    public $pin_code;

    /**
     * Create a new notification instance.
     *
     * @param $pin_code
     */
    public function __construct($pin_code)
    {
        $this->pin_code = $pin_code;
    }

    /**
     * Get the notification channels.
     *
     * @param  mixed $notifiable
     * @return array|string ['mail', 'database', 'slack', 'nexmo']
     */
    public function via($notifiable)
    {
        return ['nexmo'];
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content('Your Pin Core is: ' . $this->pin_code);
    }
}
