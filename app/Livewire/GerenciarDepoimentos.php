<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class GerenciarDepoimentos extends Component
{
    // Garante que apenas Admins acessem este componente
    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    // Função para aprovar um depoimento
    public function aprovar($id)
    {
        $depoimento = Testimonial::find($id);
        
        if ($depoimento) {
            $depoimento->update(['is_active' => true]);
            session()->flash('message', 'Depoimento aprovado com sucesso!');
        }
    }

    // Função para rejeitar um depoimento
    public function rejeitar($id)
    {
        $depoimento = Testimonial::find($id);
        
        if ($depoimento) {
            $depoimento->delete();
            session()->flash('message', 'Depoimento rejeitado e removido.');
        }
    }

    public function render()
    {
        // Busca os depoimentos pendentes de aprovação
        $depoimentosPendentes = Testimonial::where('is_active', false)->latest()->get();
        $depoimentosAprovados = Testimonial::where('is_active', true)->latest()->get();

        return view('livewire.gerenciar-depoimentos', [
            'depoimentosPendentes' => $depoimentosPendentes,
            'depoimentosAprovados' => $depoimentosAprovados
        ])->layout('layouts.admin');
    }
}
