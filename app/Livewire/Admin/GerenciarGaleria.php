<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EventoPublico;
use Illuminate\Support\Facades\Storage;

class GerenciarGaleria extends Component
{
    use WithFileUploads;

    public $titulo, $descricao, $data_realizacao;
    public $midias = []; // Agora é um array para múltiplos arquivos!

    protected $rules = [
        'titulo' => 'required|string|max:255',
        'descricao' => 'nullable|string|max:1000',
        'data_realizacao' => 'required|date',
        'midias' => 'required|array|max:30', // Aceita até 30 arquivos por vez
        'midias.*' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,webm|max:51200', // max 50MB por arquivo
    ];

    public function salvar()
    {
        $this->validate();

        $caminhos = [];
        
        // Salva cada foto/vídeo e guarda o caminho na lista
        foreach ($this->midias as $midia) {
            $caminhos[] = $midia->store('galeria', 'public');
        }

        EventoPublico::create([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_realizacao' => $this->data_realizacao,
            'midias' => $caminhos, // Salva o array de caminhos no banco
        ]);

        session()->flash('message', 'Álbum do evento postado com sucesso!');
        $this->reset(['titulo', 'descricao', 'data_realizacao', 'midias']);
    }

    public function deletar($id)
    {
        $evento = EventoPublico::find($id);
        
        if ($evento) {
            // Deleta TODAS as fotos e vídeos desse evento do servidor
            if (is_array($evento->midias)) {
                foreach ($evento->midias as $caminho) {
                    if (Storage::disk('public')->exists($caminho)) {
                        Storage::disk('public')->delete($caminho);
                    }
                }
            }
            
            $evento->delete();
            session()->flash('message', 'Evento e todas as suas mídias foram removidos!');
        }
    }

    public function render()
    {
        $eventos = EventoPublico::orderBy('data_realizacao', 'desc')->get();
        return view('livewire.admin.gerenciar-galeria', ['eventos' => $eventos])
            ->layout('layouts.admin');
    }
}