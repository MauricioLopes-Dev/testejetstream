<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GerenciarAulas extends Component
{
    use WithFileUploads;

    public $materialLinks = [];
    public $arquivos = [];
    
    // Propriedade para saber quem está logado (admin ou mentora)
    public $currentGuard;

    public function mount()
    {
        // 1. Detecta qual guard está ativo e define o escopo
        if (Auth::guard('admin')->check()) {
            $this->currentGuard = 'admin';
        } elseif (Auth::guard('mentora')->check()) {
            $this->currentGuard = 'mentora';
        } else {
            // Se não for nem admin nem mentora, bloqueia
            abort(403, 'Acesso não autorizado.');
        }

        // 2. Carrega links existentes usando o ID do guard correto
        $userId = Auth::guard($this->currentGuard)->id();
        
        $meusEventos = Event::where('user_id', $userId)->get();
        
        foreach($meusEventos as $evento) {
            $this->materialLinks[$evento->id] = $evento->material_link;
        }
    }

    public function salvarMaterial($eventoId)
    {
        $userId = Auth::guard($this->currentGuard)->id();
        $evento = Event::find($eventoId);
        
        // Verifica se o evento pertence ao usuário logado (Admin ou Mentora)
        if ($evento && $evento->user_id == $userId) {
            
            $linkFinal = $this->materialLinks[$eventoId] ?? null;

            // Lógica de Upload
            if (isset($this->arquivos[$eventoId])) {
                $caminho = $this->arquivos[$eventoId]->store('materiais', 'public');
                $linkFinal = Storage::url($caminho);
            }

            $evento->update([
                'material_link' => $linkFinal
            ]);
            
            // Limpa o input de arquivo e array temporário
            unset($this->arquivos[$eventoId]);
            
            session()->flash('message', 'Material atualizado com sucesso para: ' . $evento->titulo);
        }
    }

    public function excluirAula($eventoId)
    {
        $userId = Auth::guard($this->currentGuard)->id();
        $evento = Event::find($eventoId);

        if ($evento && $evento->user_id == $userId) {
            $evento->delete();
            session()->flash('message', 'Aula excluída com sucesso.');
        }
    }

    public function render()
    {
        $userId = Auth::guard($this->currentGuard)->id();

        $aulas = Event::with('participantes') // Certifique-se que a relação 'participantes' existe no Model
                      ->where('user_id', $userId)
                      ->orderByDesc('data_hora')
                      ->get();

        // 3. Define o layout dinamicamente
        $layout = $this->currentGuard === 'admin' ? 'layouts.admin' : 'layouts.mentora';

        return view('livewire.gerenciar-aulas', [
            'aulas' => $aulas
        ])->layout($layout);
    }
}