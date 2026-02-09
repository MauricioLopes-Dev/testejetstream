<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Solicitacao; // Adicionada a model correta conforme seu print

class MeusCursos extends Component
{
    public function baixarMaterial($aulaId)
    {
        $aula = Event::find($aulaId);

        if ($aula && $aula->material_link) {
            if (strpos($aula->material_link, '/storage/') === false && filter_var($aula->material_link, FILTER_VALIDATE_URL)) {
                return redirect()->away($aula->material_link);
            }

            $path = parse_url($aula->material_link, PHP_URL_PATH);
            $relativePath = ltrim(str_replace('/storage', '', $path), '/');

            if (Storage::disk('public')->exists($relativePath)) {
                return Storage::disk('public')->download($relativePath);
            } 
            
            return redirect()->away($aula->material_link);
        }
    }

    public function render()
    {
        $user = Auth::user();

        // 1. Lógica original dos seus cursos/eventos
        $todosCursos = $user->eventosParticipando()
                            ->orderByDesc('data_hora')
                            ->get();

        $proximasAulas = $todosCursos->filter(function($evento) {
            $fim = $evento->data_fim ?? $evento->data_hora->copy()->addHours(2);
            return $fim >= now();
        });

        $aulasPassadas = $todosCursos->diff($proximasAulas);

        // 2. BUSCA AS SOLICITAÇÕES DE MENTORIA (Model Solicitacao)
        // Buscamos as solicitações que pertencem ao usuário logado
        $candidaturas = Solicitacao::where('id', $user->id)
            ->with('mentora') // Assume que existe o relacionamento 'mentora' na model Solicitacao
            ->latest()
            ->get();

        return view('livewire.meus-cursos', [
            'proximasAulas' => $proximasAulas,
            'aulasPassadas' => $aulasPassadas,
            'candidaturas'  => $candidaturas // Agora a variável existe!
        ])->layout('layouts.app');
    }
}