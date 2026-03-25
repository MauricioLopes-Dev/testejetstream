<?php

namespace App\Livewire\Mentora;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Curso;
use App\Models\Aula;
use App\Models\Materia;
use App\Models\MaterialDidatico;
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

    // Modal de Material Didático
    public $showMaterialModal = false;
    public $material_id = null;
    public $material_materia_id;
    public $material_titulo;
    public $material_descricao;
    public $material_tipo = 'texto';
    public $material_conteudo;
    public $material_arquivo;
    public $material_ordem = 0;

    // Visualizar matérias
    public $cursoMaterias = null;
    public $showMateriasModal = false;

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
        
        // Cursos onde é mentora principal OU está atribuída via pivot
        $cursosPrincipal = $mentora->cursos()->with(['aulas', 'inscritos', 'materias.materiais'])->get();
        $cursosAtribuidos = $mentora->cursosAtribuidos()->with(['aulas', 'inscritos', 'materias.materiais'])->get();
        
        $this->cursos = $cursosPrincipal->merge($cursosAtribuidos)->unique('id');
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

    // ===== MATÉRIAS E MATERIAIS =====

    public function verMaterias($cursoId)
    {
        $this->cursoMaterias = Curso::with(['materias.materiais'])->find($cursoId);
        $this->showMateriasModal = true;
    }

    public function fecharMaterias()
    {
        $this->showMateriasModal = false;
        $this->cursoMaterias = null;
    }

    public function abrirMaterialModal($materiaId, $materialId = null)
    {
        $this->resetMaterialForm();
        $this->material_materia_id = $materiaId;

        if ($materialId) {
            $material = MaterialDidatico::findOrFail($materialId);
            $this->material_id = $material->id;
            $this->material_titulo = $material->titulo;
            $this->material_descricao = $material->descricao;
            $this->material_tipo = $material->tipo;
            $this->material_conteudo = $material->conteudo;
            $this->material_ordem = $material->ordem;
        }

        $this->showMaterialModal = true;
        $this->showMateriasModal = false;
    }

    public function resetMaterialForm()
    {
        $this->material_id = null;
        $this->material_materia_id = null;
        $this->material_titulo = '';
        $this->material_descricao = '';
        $this->material_tipo = 'texto';
        $this->material_conteudo = '';
        $this->material_arquivo = null;
        $this->material_ordem = 0;
    }

    public function salvarMaterial()
    {
        $this->validate([
            'material_titulo' => 'required|min:3',
            'material_tipo' => 'required|in:video,pdf,documento,link,texto',
            'material_conteudo' => 'nullable|string',
            'material_arquivo' => 'nullable|file|max:51200',
        ]);

        $mentora = Auth::guard('mentora')->user();

        $dados = [
            'materia_id' => $this->material_materia_id,
            'mentora_id' => $mentora->id,
            'titulo' => $this->material_titulo,
            'descricao' => $this->material_descricao,
            'tipo' => $this->material_tipo,
            'conteudo' => $this->material_conteudo,
            'ordem' => $this->material_ordem,
        ];

        if ($this->material_arquivo) {
            $path = $this->material_arquivo->store('materiais', 'public');
            $dados['arquivo_path'] = $path;
            $dados['arquivo_nome'] = $this->material_arquivo->getClientOriginalName();
            $dados['conteudo'] = Storage::url($path);
        }

        if ($this->material_id) {
            MaterialDidatico::findOrFail($this->material_id)->update($dados);
            session()->flash('message', 'Material didático atualizado!');
        } else {
            MaterialDidatico::create($dados);
            session()->flash('message', 'Material didático adicionado!');
        }

        $this->showMaterialModal = false;
        $this->carregarCursos();
    }

    public function excluirMaterial($materialId)
    {
        $material = MaterialDidatico::findOrFail($materialId);
        if ($material->arquivo_path && Storage::disk('public')->exists($material->arquivo_path)) {
            Storage::disk('public')->delete($material->arquivo_path);
        }
        $material->delete();
        session()->flash('message', 'Material excluído!');
        $this->carregarCursos();
    }

    public function render()
    {
        return view('livewire.mentora.mentora-cursos')->layout('layouts.mentora');
    }
}
