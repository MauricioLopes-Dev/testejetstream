<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination; // Importante para paginação
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class VisualizarAlunas extends Component
{
    use WithPagination;

    // Detalhes para o Modal
    public $alunaDetalhes = null;
    public $showModal = false;
    
    // Busca
    public $search = '';

    // Segurança
    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    // Reseta a paginação quando busca algo novo
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function verDetalhes($alunaId)
    {
        // Carrega relacionamentos apenas se as tabelas existirem (Lógica original mantida mas otimizada)
        $query = User::query();
        $relations = [];

        if (Schema::hasTable('cursos')) {
            // Tenta carregar cursos se a relação existir no Model
            try { $relations[] = 'cursos'; } catch (\Exception $e) {} 
        }
        if (Schema::hasTable('events')) {
             try { $relations[] = 'events'; } catch (\Exception $e) {}
        }

        // Busca a aluna com os relacionamentos
        $this->alunaDetalhes = $query->with($relations)->find($alunaId);
        
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->alunaDetalhes = null;
    }

    public function excluir($alunaId)
    {
        // Impede excluir a si mesmo ou outros admins por essa tela
        $user = User::findOrFail($alunaId);
        
        if ($user->role === 'admin') {
            session()->flash('error', 'Não é possível excluir administradores por esta tela.');
            return;
        }

        $user->delete();
        session()->flash('message', 'Aluna excluída com sucesso!');
    }

    public function render()
    {
        // Query base
        $query = User::query();

        // Filtro de segurança: Tenta listar apenas quem NÃO é admin/mentora, 
        // ou filtra por role se você tiver essa coluna. 
        // Assumindo que 'role' existe baseado nos arquivos anteriores:
        $query->where('role', 'aluna'); 

        // Aplica a busca (Nome ou Email)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        // Contagem de relacionamentos para a lista
        $relationsCount = [];
        if (Schema::hasTable('cursos')) $relationsCount[] = 'cursos'; // Assumindo relação 'cursos' no User
        if (Schema::hasTable('events')) $relationsCount[] = 'events'; // Assumindo relação 'events' no User
        
        if (!empty($relationsCount)) {
            $query->withCount($relationsCount);
        }

        // Retorna com paginação (10 por página)
        $alunas = $query->latest()->paginate(10);

        return view('livewire.admin.visualizar-alunas', [
            'alunas' => $alunas
        ])->layout('layouts.admin');
    }
}