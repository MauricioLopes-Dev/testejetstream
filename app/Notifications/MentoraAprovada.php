<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentoraAprovada extends Notification
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
            ->subject('Sua conta de Mentora foi Aprovada!')
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Temos o prazer de informar que seu cadastro como mentora no Projeto ELLAS foi aprovado.')
            ->line('Agora você pode acessar seu painel e começar a compartilhar seu conhecimento.')
            ->action('Acessar Painel de Mentora', url('/login'))
            ->line('Seja bem-vinda!');
    }
}
