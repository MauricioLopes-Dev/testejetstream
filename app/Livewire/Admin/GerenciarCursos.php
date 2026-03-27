<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Curso;
use App\Models\AreaAtuacao;
use App\Models\Mentora;
use Illuminate\Support\Facades\Auth;

class GerenciarCursos extends Component
{
    // Controle do Modal
    public $showModal = false;
    public $showDetalhesModal = false;
    
    // Campos do formulário
    public $curso_id = null;
    public $nome;
    public $descricao;
    public $area_atuacao_id;
    public $area_personalizada;
    public $data_inicio;
    public $data_fim;
    public $mentora_id;
    public $mentoras_ids = [];
    public $ativo = true;
    public $max_vagas = 30;
    public $duracao_horas;
    public $mostrarAreaPersonalizada = false;

    // Curso selecionado para detalhes
    public $cursoDetalhes = null;

    // Regras de validação
    protected $rules = [
        'nome' => 'required|min:3',
        'area_atuacao_id' => 'nullable|exists:areas_atuacao,id',
        'area_personalizada' => 'nullable|string|max:255',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date|after:data_inicio',
        'mentora_id' => 'nullable|exists:mentoras,id',
        'max_vagas' => 'required|integer|min:1|max:500',
        'duracao_horas' => 'nullable|integer|min:1',
    ];

    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    public function updatedAreaAtuacaoId($value)
    {
        $area = AreaAtuacao::find($value);
        $this->mostrarAreaPersonalizada = $area && strtolower($area->nome) === 'outro';
    }

    public function abrirModal($cursoId = null)
    {
        $this->resetForm();
        
        if ($cursoId) {
            $curso = Curso::with('mentoras')->findOrFail($cursoId);
            
            $this->curso_id = $curso->id;
            $this->nome = $curso->nome;
            $this->descricao = $curso->descricao;
            $this->area_atuacao_id = $curso->area_atuacao_id;
            $this->area_personalizada = $curso->area_personalizada;
            $this->data_inicio = $curso->data_inicio ? $curso->data_inicio->format('Y-m-d') : '';
            $this->data_fim = $curso->data_fim ? $curso->data_fim->format('Y-m-d') : '';
            $this->mentora_id = $curso->mentora_id;
            $this->mentoras_ids = $curso->mentoras->pluck('id')->toArray();
            $this->ativo = $curso->ativo;
            $this->max_vagas = $curso->max_vagas;
            $this->duracao_horas = $curso->duracao_horas;
            
            $this->updatedAreaAtuacaoId($this->area_atuacao_id);
        }
        
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function verDetalhes($cursoId)
    {
        $this->cursoDetalhes = Curso::with(['areaAtuacao', 'mentora', 'mentoras', 'inscritos', 'materias.materiais', 'aulas'])->findOrFail($cursoId);
        $this->showDetalhesModal = true;
    }

    public function fecharDetalhes()
    {
        $this->showDetalhesModal = false;
        $this->cursoDetalhes = null;
    }

    public function resetForm()
    {
        $this->reset([
            'curso_id', 'nome', 'descricao', 'area_atuacao_id', 
            'area_personalizada', 'data_inicio', 'data_fim', 
            'mentora_id', 'mentoras_ids', 'ativo', 'max_vagas', 
            'duracao_horas', 'mostrarAreaPersonalizada'
        ]);
        $this->ativo = true;
        $this->max_vagas = 30;
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
            'mentora_id' => $this->mentora_id ?: null,
            'ativo' => $this->ativo,
            'max_vagas' => $this->max_vagas,
            'duracao_horas' => $this->duracao_horas ?: null,
        ];

        if ($this->curso_id) {
            $curso = Curso::findOrFail($this->curso_id);
            $curso->update($dados);
            // Sincronizar mentoras atribuídas
            $curso->mentoras()->sync($this->mentoras_ids);
            session()->flash('message', 'Curso atualizado com sucesso!');
        } else {
            $curso = Curso::create($dados);
            // Atribuir mentoras ao curso
            if (!empty($this->mentoras_ids)) {
                $curso->mentoras()->sync($this->mentoras_ids);
            }
            session()->flash('message', 'Curso criado com sucesso!');
        }

        $this->fecharModal();
    }

    public function excluir($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $curso->mentoras()->detach();
        $curso->delete();
        session()->flash('message', 'Curso excluído com sucesso!');
    }

    public function toggleAtivo($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $curso->update(['ativo' => !$curso->ativo]);
        session()->flash('message', $curso->ativo ? 'Curso ativado!' : 'Curso desativado!');
    }

    public function render()
    {
        return view('livewire.admin.gerenciar-cursos', [
            'cursos'   => Curso::with(['areaAtuacao', 'mentora', 'mentoras', 'inscritos'])->latest()->get(),
            'areas'    => AreaAtuacao::orderBy('nome')->get(),
            'mentoras' => Mentora::where('status_aprovacao', 'aprovado')->orderBy('nome')->get(),
        ])->layout('layouts.admin');
    }
}
