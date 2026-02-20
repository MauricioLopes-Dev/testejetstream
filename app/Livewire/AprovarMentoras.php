<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Mentora; // Importante para lidar com a tabela correta
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AprovarMentoras extends Component
{
    use WithPagination;

    public function mount()
    {
        // Verifica se é admin
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }
    }

    // Aprovar uma ALUNA que pediu para ser mentora
    public function aprovarAluna($userId)
    {
        $user = User::findOrFail($userId);

        // AQUI ESTÁ O PULO DO GATO:
        // Como 'users' e 'mentoras' são tabelas separadas, você precisa 'promover' a aluna.
        // O ideal seria abrir um modal para preencher os dados faltantes (Area, Experiencia),
        // mas por enquanto vamos apenas limpar o pedido para não travar o sistema.
        
        $user->update([
            'solicitou_mentoria' => false 
        ]);

        session()->flash('message', "Solicitação da aluna {$user->name} processada! (Lembre-se de criar o cadastro dela em Mentoras se necessário)");
    }

    // Aprovar uma MENTORA que se cadastrou direto pelo site
    public function aprovarMentora($mentoraId)
    {
        $mentora = Mentora::findOrFail($mentoraId);
        
        $mentora->update([
            'status_aprovacao' => 'aprovado'
        ]);

        // Envia notificação se a classe existir
        if (class_exists(\App\Notifications\MentoraAprovada::class)) {
            $mentora->notify(new \App\Notifications\MentoraAprovada());
        }

        session()->flash('message', "Mentora {$mentora->nome} aprovada com sucesso! Agora ela pode logar.");
    }
    
    public function reprovarMentora($mentoraId)
    {
        $mentora = Mentora::findOrFail($mentoraId);
        
        $mentora->update([
            'status_aprovacao' => 'reprovado',
            'reprovado_em' => now()
        ]);

         if (class_exists(\App\Notifications\MentoraReprovada::class)) {
            $mentora->notify(new \App\Notifications\MentoraReprovada());
        }

        session()->flash('message', "Cadastro da mentora {$mentora->nome} reprovado.");
    }

    public function render()
    {
        // 1. Busca Alunas que pediram mentoria (Tabela Users)
        // Removemos o 'where role' pois a tabela users só tem alunas
        $alunasCandidatas = User::where('solicitou_mentoria', true)
                                ->latest()
                                ->get();

        // 2. Busca Mentoras que se cadastraram e estão pendentes (Tabela Mentoras)
        $mentorasPendentes = Mentora::where('status_aprovacao', 'pendente')
                                    ->whereNotNull('email_verificado_at') // Só mostra quem confirmou email
                                    ->latest()
                                    ->get();

        return view('livewire.aprovar-mentoras', [
            'alunasCandidatas' => $alunasCandidatas,
            'mentorasPendentes' => $mentorasPendentes
        ])->layout('layouts.admin');
    }
}