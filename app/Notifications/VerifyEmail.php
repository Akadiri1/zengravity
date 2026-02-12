<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmail extends BaseVerifyEmail
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verify Your ZENGRAVITY Identity'))
            ->greeting(Lang::get('Hello, Creator!'))
            ->line(Lang::get('Welcome to the ZENGRAVITY ecosystem. We\'re excited to have you join our neural network of founders and creators.'))
            ->line(Lang::get('Before you can activate our AI-powered features, we need to verify your digital footprint.'))
            ->action(Lang::get('Verify Email Address'), $verificationUrl)
            ->line(Lang::get('If you did not initiate this registration, no further action is required.'))
            ->salutation(Lang::get('Stay Zen,' . "\r\n" . 'The ZENGRAVITY Team'));
    }
}
