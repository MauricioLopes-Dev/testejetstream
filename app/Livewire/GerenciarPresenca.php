<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Aula;
use App\Models\User;
use App\Models\Presenca;
use Illuminate\Support\Facades\Auth;

class GerenciarPresenca extends Component
{
    public $aulaId;
    public $alunas;
    public $presencas = [];

    public function mount($aulaId)
    {
        if (!Auth::guard('mentora')->check()) {
            abort(403);
        }

        $this->aulaId = $aulaId;
        $aula = Aula::with('curso.inscritos')->findOrFail($aulaId);
        $this->alunas = $aula->curso->inscritos;

        // Carrega presenças existentes
        $presencasExistentes = Presenca::where('aula_id', $aulaId)->get();
        foreach ($presencasExistentes as $p) {
            $this->presencas[$p->user_id] = $p->presente;
        }
    }

    public function togglePresenca($alunaId)
    {
        $presente = !($this->presencas[$alunaId] ?? false);
        $this->presencas[$alunaId] = $presente;

        Presenca::updateOrCreate(
            ['aula_id' => $this->aulaId, 'user_id' => $alunaId],
            ['presente' => $presente]
        );

        session()->flash('message', 'Presença atualizada com sucesso!');
    }

    public function render()
    {
        $aula = Aula::find($this->aulaId);
        return view('livewire.gerenciar-presenca', [
            'aula' => $aula
        ])->layout('layouts.mentora');
    }
}
