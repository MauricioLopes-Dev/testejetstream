<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailWithCode extends Notification
{
    use Queueable;

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
            ->subject('Seu Código de Verificação - Projeto Ellas')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Obrigado por se cadastrar no Projeto Ellas.')
            ->line('Para validar seu cadastro e acessar a plataforma, use o código de 6 dígitos abaixo:')
            ->line('**' . $notifiable->verification_code . '**')
            ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.');
    }
}
