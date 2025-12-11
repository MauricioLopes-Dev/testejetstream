<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // <--- Necessário para upload
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GerenciarAulas extends Component
{
    use WithFileUploads; // <--- Habilita uploads

    public $materialLinks = []; // Para inputs de texto
    public $arquivos = [];      // Para inputs de arquivo (Uploads)

    public function mount()
    {
        if (Auth::user()->role !== 'mentora' && Auth::user()->role !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Carrega links existentes
        $meusEventos = Event::where('user_id', Auth::id())->get();
        foreach($meusEventos as $evento) {
            $this->materialLinks[$evento->id] = $evento->material_link;
        }
    }

    public function salvarMaterial($eventoId)
    {
        $evento = Event::find($eventoId);
        
        if ($evento && $evento->user_id == Auth::id()) {
            
            $linkFinal = $this->materialLinks[$eventoId] ?? null;

            // Lógica de Upload: Se tiver arquivo, ele ganha prioridade
            if (isset($this->arquivos[$eventoId])) {
                // Salva na pasta 'materiais' dentro do disco público
                $caminho = $this->arquivos[$eventoId]->store('materiais', 'public');
                // Gera a URL para acesso
                $linkFinal = Storage::url($caminho);
            }

            $evento->update([
                'material_link' => $linkFinal
            ]);
            
            // Limpa o input de arquivo após salvar para liberar memória
            unset($this->arquivos[$eventoId]);
            
            session()->flash('message', 'Material atualizado com sucesso para: ' . $evento->titulo);
        }
    }

    public function render()
    {
        $aulas = Event::with('participantes')
                      ->where('user_id', Auth::id())
                      ->orderByDesc('data_hora')
                      ->get();

        return view('livewire.gerenciar-aulas', [
            'aulas' => $aulas
        ])->layout('layouts.app');
    }
}