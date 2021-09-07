<?php

namespace App\Notifications\User;

use App\Models\EmailVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * @var EmailVerification $emailVerify
     */
    public $emailVerify;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(EmailVerification $emailVerify)
    {
        $this->emailVerify = $emailVerify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Kimberly - завершение регистрации')
            ->greeting('Уважаемый(ая) ' . $this->emailVerify->user->first_name)
            ->line('Для завершения регистрации в приложении Kimberly введите на форме регистрации проверочный код: ' . $this->emailVerify->verification_code)
            ->salutation('С уважением, команда Kimberly');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
