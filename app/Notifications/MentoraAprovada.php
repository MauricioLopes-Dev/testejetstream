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
            ->subject('Sua conta de Mentora foi Aprovada! - Projeto ELLAS')
            ->greeting('Olá ' . $notifiable->nome . '!')
            ->line('Temos o prazer de informar que seu cadastro como **mentora** no Projeto ELLAS foi **aprovado** pela nossa equipe administrativa.')
            ->line('Agora você pode acessar seu painel exclusivo de mentora e começar a compartilhar seu conhecimento com as alunas.')
            ->line('---')
            ->line('**INSTRUÇÕES DE ACESSO:**')
            ->line('O painel de mentora possui uma rota de acesso exclusiva. Para fazer login, utilize o link abaixo:')
            ->action('Acessar Painel de Mentora', url('/mentora'))
            ->line('**Importante:** Use o email e a senha que você cadastrou durante sua inscrição como mentora.')
            ->line('Caso não consiga acessar, tente o link direto: ' . url('/mentora'))
            ->line('---')
            ->line('Seja muito bem-vinda ao time de mentoras do Projeto ELLAS!')
            ->salutation('Com carinho, Equipe Projeto ELLAS');
    }
}
