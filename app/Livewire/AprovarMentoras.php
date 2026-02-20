<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Team;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AprovarMentoras extends Component
{
    use WithPagination;

    // Apenas Admins podem acessar (verificação extra além da rota)
    public function mount()
    {
        // CORREÇÃO: Verifica especificamente se o usuário está logado no guard 'admin'
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }
    }

    public function aprovar($userId)
    {
        $user = User::findOrFail($userId);

        // 1. Muda o papel para Mentora e reseta o pedido
        $user->update([
            'role' => 'mentora',
            'solicitou_mentoria' => false 
        ]);

        // 2. Garante que ela tenha um Time Pessoal (Exigência do Jetstream)
        if (!$user->personalTeam()) {
            $team = Team::forceCreate([
                'user_id' => $user->id,
                'name' => explode(' ', $user->name, 2)[0]."'s Team",
                'personal_team' => true,
            ]);
            
            $user->forceFill(['current_team_id' => $team->id])->save();
        }

        session()->flash('message', "A usuária {$user->name} agora é uma Mentora! 🎉");
    }

    public function render()
    {
        // FILTRO ATUALIZADO:
        // Lista apenas alunas que solicitaram mentoria (solicitou_mentoria = true)
        // Ordena por 'updated_at' para ver quem pediu mais recentemente
        $candidatas = User::where('role', 'aluna')
                          ->where('solicitou_mentoria', true)
                          ->orderByDesc('updated_at')
                          ->paginate(10);

        return view('livewire.aprovar-mentoras', [
            'candidatas' => $candidatas
        ])->layout('layouts.admin'); // CORREÇÃO: Aponta para o layout do painel administrativo
    }
}