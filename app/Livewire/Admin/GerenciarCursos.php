<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Curso;
use App\Models\AreaAtuacao;
use App\Models\Mentora;
use Illuminate\Support\Facades\Auth;

class GerenciarCursos extends Component
{
    public $cursos;
    public $showModal = false;
    
    // Campos do formulário
    public $curso_id = null;
    public $nome;
    public $descricao;
    public $area_atuacao_id;
    public $area_personalizada;
    public $data_inicio;
    public $data_fim;
    public $mentora_id;
    public $ativo = true;

    public $areas;
    public $mentoras;
    public $mostrarAreaPersonalizada = false;

    protected $rules = [
        'nome' => 'required|min:3',
        'area_atuacao_id' => 'nullable|exists:areas_atuacao,id',
        'area_personalizada' => 'nullable|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after:data_inicio',
        'mentora_id' => 'nullable|exists:mentoras,id',
    ];

    public function mount()
    {
        if (Auth::guard('admin')->guest()) {
            abort(403, 'Acesso não autorizado.');
        }

        $this->carregarDados();
    }

    public function carregarDados()
    {
        $this->cursos = Curso::with(['areaAtuacao', 'mentora'])->latest()->get();
        $this->areas = AreaAtuacao::all();
        $this->mentoras = Mentora::where('status_aprovacao', 'aprovado')->get();
    }

    public function updatedAreaAtuacaoId($value)
    {
        // Se selecionar "Outro" (vamos assumir que existe uma área com nome "Outro")
        $area = AreaAtuacao::find($value);
        $this->mostrarAreaPersonalizada = $area && strtolower($area->nome) === 'outro';
    }

    public function abrirModal($cursoId = null)
    {
        $this->resetForm();
        
        if ($cursoId) {
            $curso = Curso::find($cursoId);
            $this->curso_id = $curso->id;
            $this->nome = $curso->nome;
            $this->descricao = $curso->descricao;
            $this->area_atuacao_id = $curso->area_atuacao_id;
            $this->area_personalizada = $curso->area_personalizada;
            $this->data_inicio = $curso->data_inicio->format('Y-m-d');
            $this->data_fim = $curso->data_fim->format('Y-m-d');
            $this->mentora_id = $curso->mentora_id;
            $this->ativo = $curso->ativo;
            
            $this->updatedAreaAtuacaoId($this->area_atuacao_id);
        }
        
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->curso_id = null;
        $this->nome = '';
        $this->descricao = '';
        $this->area_atuacao_id = null;
        $this->area_personalizada = '';
        $this->data_inicio = '';
        $this->data_fim = '';
        $this->mentora_id = null;
        $this->ativo = true;
        $this->mostrarAreaPersonalizada = false;
    }

    public function salvar()
    {
        $this->validate();

        $dados = [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'area_atuacao_id' => $this->mostrarAreaPersonalizada ? null : $this->area_atuacao_id,
            'area_personalizada' => $this->mostrarAreaPersonalizada ? $this->area_personalizada : null,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'mentora_id' => $this->mentora_id,
            'ativo' => $this->ativo,
        ];

        if ($this->curso_id) {
            Curso::find($this->curso_id)->update($dados);
            session()->flash('message', 'Curso atualizado com sucesso!');
        } else {
            Curso::create($dados);
            session()->flash('message', 'Curso criado com sucesso!');
        }

        $this->fecharModal();
        $this->carregarDados();
    }

    public function excluir($cursoId)
    {
        Curso::find($cursoId)->delete();
        session()->flash('message', 'Curso excluído com sucesso!');
        $this->carregarDados();
    }

    public function render()
    {
        return view('livewire.admin.gerenciar-cursos')->layout('layouts.admin');
    }
}
