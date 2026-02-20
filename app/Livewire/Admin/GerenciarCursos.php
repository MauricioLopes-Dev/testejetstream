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
    public $mostrarAreaPersonalizada = false;

    // Regras de validação
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
        // VERIFICAÇÃO DE SEGURANÇA: Garante que é admin
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    // Monitora mudanças no select de Área de Atuação
    public function updatedAreaAtuacaoId($value)
    {
        $area = AreaAtuacao::find($value);
        // Verifica se a área selecionada é "Outro" para mostrar campo extra
        // Ajuste a string 'outro' conforme está no seu banco de dados
        $this->mostrarAreaPersonalizada = $area && strtolower($area->nome) === 'outro';
    }

    public function abrirModal($cursoId = null)
    {
        $this->resetForm();
        
        if ($cursoId) {
            $curso = Curso::findOrFail($cursoId);
            
            $this->curso_id = $curso->id;
            $this->nome = $curso->nome;
            $this->descricao = $curso->descricao;
            $this->area_atuacao_id = $curso->area_atuacao_id;
            $this->area_personalizada = $curso->area_personalizada;
            
            // Formata as datas para o input HTML (Y-m-d)
            $this->data_inicio = $curso->data_inicio ? $curso->data_inicio->format('Y-m-d') : '';
            $this->data_fim = $curso->data_fim ? $curso->data_fim->format('Y-m-d') : '';
            
            $this->mentora_id = $curso->mentora_id;
            $this->ativo = $curso->ativo;
            
            // Dispara a verificação da área personalizada
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
        $this->reset([
            'curso_id', 'nome', 'descricao', 'area_atuacao_id', 
            'area_personalizada', 'data_inicio', 'data_fim', 
            'mentora_id', 'ativo', 'mostrarAreaPersonalizada'
        ]);
        $this->ativo = true; // Valor padrão
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
            'mentora_id' => $this->mentora_id ?: null, // Garante null se vazio
            'ativo' => $this->ativo,
        ];

        if ($this->curso_id) {
            $curso = Curso::findOrFail($this->curso_id);
            $curso->update($dados);
            session()->flash('message', 'Curso atualizado com sucesso!');
        } else {
            Curso::create($dados);
            session()->flash('message', 'Curso criado com sucesso!');
        }

        $this->fecharModal();
    }

    public function excluir($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $curso->delete();
        session()->flash('message', 'Curso excluído com sucesso!');
    }

    public function render()
    {
        // Carrega os dados aqui para estarem sempre atualizados e não pesar a sessão
        return view('livewire.admin.gerenciar-cursos', [
            'cursos'   => Curso::with(['areaAtuacao', 'mentora'])->latest()->get(),
            'areas'    => AreaAtuacao::orderBy('nome')->get(),
            'mentoras' => Mentora::where('status_aprovacao', 'aprovado')->orderBy('nome')->get(),
        ])->layout('layouts.admin');
    }
}