<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class VisualizarAlunas extends Component
{
    use WithPagination;

    public $alunaDetalhes = null;
    public $showModal = false;
    public $search = '';

    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function verDetalhes($alunaId)
    {
        $query = User::query();
        
        // Carrega relacionamentos dinamicamente se existirem no Model
        $relations = [];
        if (method_exists(User::class, 'cursos')) {
            $relations[] = 'cursos';
        }
        if (method_exists(User::class, 'events')) {
            $relations[] = 'events';
        }

        $this->alunaDetalhes = $query->with($relations)->findOrFail($alunaId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->alunaDetalhes = null;
    }

    public function excluir($alunaId)
    {
        $user = User::findOrFail($alunaId);
        $user->delete();
        session()->flash('message', 'Aluna excluída com sucesso!');
    }

    public function render()
    {
        $query = User::query();

        // CORREÇÃO: Removemos o filtro ->where('role', 'aluna')
        // Como a tabela 'users' é dedicada às alunas, não precisamos filtrar.
        
        // Se você quisesse filtrar apenas quem NÃO é admin (caso compartilhassem a tabela):
        // $query->where('is_admin', false); 
        // Mas no seu caso de tabelas separadas, o código abaixo é suficiente:

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Verifica quais contagens carregar
        $relationsCount = [];
        if (method_exists(User::class, 'cursos')) {
            $relationsCount[] = 'cursos';
        }
        if (method_exists(User::class, 'events')) {
            $relationsCount[] = 'events';
        }

        if (!empty($relationsCount)) {
            $query->withCount($relationsCount);
        }

        return view('livewire.admin.visualizar-alunas', [
            'alunas' => $query->latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}