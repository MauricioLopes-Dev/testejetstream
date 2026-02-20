<?php

namespace App\Livewire\Aluna;

use Livewire\Component;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class CursosAluna extends Component
{
    public $cursosDisponiveis;
    public $meusCursos;
    public $cursoSelecionado = null;
    public $showModal = false;

    public function mount()
    {
        $this->carregarCursos();
    }

    public function carregarCursos()
    {
        $user = Auth::user();
        
        // Cursos em que está inscrito
        $this->meusCursos = $user->cursos()->with(['mentora', 'aulas'])->get();
        
        // Cursos disponíveis (ativos e não inscritos)
        $cursosInscritosIds = $this->meusCursos->pluck('id')->toArray();
        $this->cursosDisponiveis = Curso::where('ativo', true)
                                        ->whereNotIn('id', $cursosInscritosIds)
                                        ->with('mentora')
                                        ->get();
    }

    public function inscrever($cursoId)
    {
        $user = Auth::user();
        $user->cursos()->attach($cursoId);
        
        session()->flash('message', 'Inscrição realizada com sucesso!');
        $this->carregarCursos();
    }

    public function cancelarInscricao($cursoId)
    {
        $user = Auth::user();
        $user->cursos()->detach($cursoId);
        
        session()->flash('message', 'Inscrição cancelada com sucesso!');
        $this->carregarCursos();
        $this->fecharModal();
    }

    public function verCurso($cursoId)
    {
        $this->cursoSelecionado = Curso::with(['mentora', 'aulas'])->find($cursoId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->cursoSelecionado = null;
    }

    public function render()
    {
        return view('livewire.aluna.cursos-aluna')->layout('layouts.app');
    }
}
