<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; // Importante para paginação
use App\Models\Mentora;
use Illuminate\Support\Facades\Auth;

class VisualizarMentoras extends Component
{
    use WithPagination;

    // Propriedades para o Modal
    public $mentoraDetalhes = null;
    public $showModal = false;

    // Campo de busca
    public $search = '';

    public function mount()
    {
        // VERIFICAÇÃO DE SEGURANÇA
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    // Reseta a paginação quando o usuário digita algo na busca
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function verDetalhes($mentoraId)
    {
        // Carrega a mentora com seus relacionamentos
        // Certifique-se de que os métodos 'areaAtuacao' e 'cursos' existem no Model Mentora
        $this->mentoraDetalhes = Mentora::with(['areaAtuacao', 'cursos'])->findOrFail($mentoraId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->mentoraDetalhes = null;
    }

    public function excluir($mentoraId)
    {
        $mentora = Mentora::find($mentoraId);

        if ($mentora) {
            $mentora->delete();
            session()->flash('message', 'Mentora excluída com sucesso!');
        }
    }

    public function render()
    {
        // Query Base: Apenas mentoras aprovadas
        $query = Mentora::with('areaAtuacao')
                        ->where('status_aprovacao', 'aprovado');

        // Aplica o filtro de busca se houver algo digitado
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nome', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Retorna com paginação (10 por página) e ordenado pelo mais recente
        return view('livewire.admin.visualizar-mentoras', [
            'mentoras' => $query->latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}