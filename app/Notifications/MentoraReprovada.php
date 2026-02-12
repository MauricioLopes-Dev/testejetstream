<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentoraReprovada extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Atualização sobre seu cadastro de Mentora')
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Infelizmente, seu cadastro como mentora no Projeto ELLAS não foi aprovado neste momento.')
            ->line('Você poderá realizar uma nova solicitação após 30 dias.')
            ->line('Agradecemos seu interesse em participar da nossa comunidade.');
    }
}
