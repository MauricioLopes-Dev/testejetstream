<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

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
        // Garantimos que o código seja pego do objeto notifiable (User)
        $code = $notifiable->verification_code;

        return (new MailMessage)
            ->subject('Seu Código de Verificação - Projeto Ellas')
            ->greeting('Olá, ' . $notifiable->name . '!')
            ->line('Obrigado por se cadastrar no Projeto Ellas.')
            ->line('Para validar seu cadastro e acessar a plataforma, use o código de 6 dígitos abaixo:')
            ->line(new HtmlString('<div style="text-align: center; margin: 30px 0;">
                <span style="font-size: 32px; font-weight: bold; letter-spacing: 10px; color: #04cbef; background: #1a1a2e; padding: 15px 30px; border-radius: 10px; border: 1px solid #04cbef;">
                    ' . $code . '
                </span>
            </div>'))
            ->line('Digite este código na página de verificação para liberar seu acesso.')
            ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.')
            ->salutation('Atenciosamente, Equipe Projeto Ellas');
    }
}
