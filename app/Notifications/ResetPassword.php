<?php

namespace App\Notifications;


use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Obtenha os canais de entrega da notificação
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [\LaravelDoctrine\ORM\Notifications\DoctrineChannel::class];
    }

    /**
     * @param $notifiable
     * @return $this
     */
    public function toEntity($notifiable)
    {
        return (new \App\Entities\Notification)
            ->to($notifiable)
            ->success()
            ->message('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url(config('app.url').route('password.reset', $this->token, false)));
    }

}
