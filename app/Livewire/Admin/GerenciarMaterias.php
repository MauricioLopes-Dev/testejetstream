<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Curso;
use App\Models\Materia;
use App\Models\MaterialDidatico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GerenciarMaterias extends Component
{
    use WithFileUploads;

    public $cursoId;
    public $curso;

    // Modal de Matéria
    public $showMateriaModal = false;
    public $materia_id = null;
    public $materia_titulo;
    public $materia_descricao;
    public $materia_ordem = 0;

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

    protected function rules()
    {
        return [
            'materia_titulo' => 'required|min:3',
            'materia_descricao' => 'nullable|string',
            'materia_ordem' => 'integer|min:0',
        ];
    }

    protected function materialRules()
    {
        return [
            'material_titulo' => 'required|min:3',
            'material_descricao' => 'nullable|string',
            'material_tipo' => 'required|in:video,pdf,documento,link,texto',
            'material_conteudo' => 'nullable|string',
            'material_arquivo' => 'nullable|file|max:51200', // 50MB
            'material_ordem' => 'integer|min:0',
        ];
    }

    public function mount($cursoId)
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }
        $this->cursoId = $cursoId;
        $this->carregarCurso();
    }

    public function carregarCurso()
    {
        $this->curso = Curso::with(['materias.materiais.mentora', 'mentoras'])->findOrFail($this->cursoId);
    }

    // ===== MATÉRIAS =====

    public function abrirMateriaModal($materiaId = null)
    {
        $this->resetMateriaForm();

        if ($materiaId) {
            $materia = Materia::findOrFail($materiaId);
            $this->materia_id = $materia->id;
            $this->materia_titulo = $materia->titulo;
            $this->materia_descricao = $materia->descricao;
            $this->materia_ordem = $materia->ordem;
        } else {
            $this->materia_ordem = $this->curso->materias->count();
        }

        $this->showMateriaModal = true;
    }

    public function resetMateriaForm()
    {
        $this->materia_id = null;
        $this->materia_titulo = '';
        $this->materia_descricao = '';
        $this->materia_ordem = 0;
    }

    public function salvarMateria()
    {
        $this->validate($this->rules());

        $dados = [
            'curso_id' => $this->cursoId,
            'titulo' => $this->materia_titulo,
            'descricao' => $this->materia_descricao,
            'ordem' => $this->materia_ordem,
        ];

        if ($this->materia_id) {
            Materia::findOrFail($this->materia_id)->update($dados);
            session()->flash('message', 'Matéria atualizada com sucesso!');
        } else {
            Materia::create($dados);
            session()->flash('message', 'Matéria criada com sucesso!');
        }

        $this->showMateriaModal = false;
        $this->carregarCurso();
    }

    public function excluirMateria($materiaId)
    {
        Materia::findOrFail($materiaId)->delete();
        session()->flash('message', 'Matéria excluída com sucesso!');
        $this->carregarCurso();
    }

    // ===== MATERIAIS DIDÁTICOS =====

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
        } else {
            $materia = Materia::findOrFail($materiaId);
            $this->material_ordem = $materia->materiais->count();
        }

        $this->showMaterialModal = true;
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
        $this->validate($this->materialRules());

        $dados = [
            'materia_id' => $this->material_materia_id,
            'titulo' => $this->material_titulo,
            'descricao' => $this->material_descricao,
            'tipo' => $this->material_tipo,
            'conteudo' => $this->material_conteudo,
            'ordem' => $this->material_ordem,
        ];

        // Upload de arquivo se fornecido
        if ($this->material_arquivo) {
            $path = $this->material_arquivo->store('materiais', 'public');
            $dados['arquivo_path'] = $path;
            $dados['arquivo_nome'] = $this->material_arquivo->getClientOriginalName();
            $dados['conteudo'] = Storage::url($path);
        }

        if ($this->material_id) {
            MaterialDidatico::findOrFail($this->material_id)->update($dados);
            session()->flash('message', 'Material didático atualizado com sucesso!');
        } else {
            MaterialDidatico::create($dados);
            session()->flash('message', 'Material didático adicionado com sucesso!');
        }

        $this->showMaterialModal = false;
        $this->carregarCurso();
    }

    public function excluirMaterial($materialId)
    {
        $material = MaterialDidatico::findOrFail($materialId);
        
        // Remove arquivo se existir
        if ($material->arquivo_path && Storage::disk('public')->exists($material->arquivo_path)) {
            Storage::disk('public')->delete($material->arquivo_path);
        }

        $material->delete();
        session()->flash('message', 'Material didático excluído com sucesso!');
        $this->carregarCurso();
    }

    public function render()
    {
        return view('livewire.admin.gerenciar-materias')->layout('layouts.admin');
    }
}
