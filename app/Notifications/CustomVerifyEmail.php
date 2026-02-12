<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->view('emails.verify', [
                'url' => $verificationUrl,
                'user' => $notifiable,
            ])
            ->subject('Confirmez votre adresse e-mail');
    }
}
