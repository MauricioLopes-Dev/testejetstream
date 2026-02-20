<?php

namespace App\Livewire\Mentora;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Curso;
use App\Models\Aula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MentoraCursos extends Component
{
    use WithFileUploads;

    public $cursos;
    public $cursoSelecionado = null;
    public $showModalAula = false;
    
    // Campos da Aula
    public $aula_id = null;
    public $titulo;
    public $descricao;
    public $tipo = 'video';
    public $conteudo;
    public $arquivo;
    public $data_aula;
    public $ordem = 0;

    protected $rules = [
        'titulo' => 'required|min:3',
        'tipo' => 'required|in:video,pdf,link_meet,texto',
        'conteudo' => 'nullable|string',
        'arquivo' => 'nullable|file|max:10240', // 10MB
        'data_aula' => 'nullable|date',
        'ordem' => 'integer',
    ];

    public function mount()
    {
        if (!Auth::guard('mentora')->check()) {
            abort(403);
        }
        $this->carregarCursos();
    }

    public function carregarCursos()
    {
        $mentora = Auth::guard('mentora')->user();
        $this->cursos = $mentora->cursos()->with(['aulas', 'inscritos'])->get();
    }

    public function abrirModalAula($cursoId, $aulaId = null)
    {
        $this->resetForm();
        $this->cursoSelecionado = Curso::find($cursoId);
        
        if ($aulaId) {
            $aula = Aula::find($aulaId);
            $this->aula_id = $aula->id;
            $this->titulo = $aula->titulo;
            $this->descricao = $aula->descricao;
            $this->tipo = $aula->tipo;
            $this->conteudo = $aula->conteudo;
            $this->data_aula = $aula->data_aula ? $aula->data_aula->format('Y-m-d\TH:i') : null;
            $this->ordem = $aula->ordem;
        }
        
        $this->showModalAula = true;
    }

    public function resetForm()
    {
        $this->aula_id = null;
        $this->titulo = '';
        $this->descricao = '';
        $this->tipo = 'video';
        $this->conteudo = '';
        $this->arquivo = null;
        $this->data_aula = null;
        $this->ordem = 0;
    }

    public function salvarAula()
    {
        $this->validate();

        $dados = [
            'curso_id' => $this->cursoSelecionado->id,
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo,
            'conteudo' => $this->conteudo,
            'data_aula' => $this->data_aula,
            'ordem' => $this->ordem,
        ];

        if ($this->arquivo) {
            $path = $this->arquivo->store('aulas', 'public');
            $dados['conteudo'] = Storage::url($path);
        }

        if ($this->aula_id) {
            Aula::find($this->aula_id)->update($dados);
            session()->flash('message', 'Aula atualizada com sucesso!');
        } else {
            Aula::create($dados);
            session()->flash('message', 'Aula criada com sucesso!');
        }

        $this->showModalAula = false;
        $this->carregarCursos();
    }

    public function excluirAula($aulaId)
    {
        Aula::find($aulaId)->delete();
        session()->flash('message', 'Aula excluída com sucesso!');
        $this->carregarCursos();
    }

    public function render()
    {
        return view('livewire.mentora.mentora-cursos')->layout('layouts.mentora');
    }
}
