<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MentoraVerificationCode extends Notification
{
    use Queueable;

    protected $codigo;

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Código de Verificação - Projeto ELLAS')
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Seu código de verificação para o cadastro de mentora é:')
            ->line($this->codigo)
            ->line('Insira este código na tela de verificação para prosseguir com seu cadastro.');
    }
}
