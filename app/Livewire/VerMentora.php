<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Solicitacao;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSolicitacaoMentoria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // <--- Importante para o download

class VerMentora extends Component
{
    public User $mentora;
    public $statusSolicitacao = null;

    public function mount($id)
    {
        $this->mentora = User::findOrFail($id);
        
        if ($this->mentora->role !== 'mentora') { abort(404); }

        $solicitacao = Solicitacao::where('mentora_id', $this->mentora->id)
            ->where('aluna_id', Auth::id())
            ->latest()
            ->first();

        if ($solicitacao) {
            $this->statusSolicitacao = $solicitacao->status;
        }
    }

    public function solicitarMentoria()
    {
        set_time_limit(120);

        if (Auth::id() === $this->mentora->id) {
            return;
        }

        if ($this->statusSolicitacao === 'pendente' || $this->statusSolicitacao === 'aceito') {
            return;
        }

        $solicitacao = Solicitacao::create([
            'mentora_id' => $this->mentora->id,
            'aluna_id' => Auth::id(),
            'status' => 'pendente'
        ]);

        try {
            Mail::to($this->mentora->email)->send(new NovaSolicitacaoMentoria($solicitacao));
        } catch (\Throwable $e) {
            Log::error('Erro ao enviar email: ' . $e->getMessage());
        }

        $this->statusSolicitacao = 'pendente';
    }

    public function inscreverAula($aulaId)
    {
        $aula = Event::find($aulaId);
        
        if ($aula) {
            $jaInscrita = $aula->participantes()->where('user_id', Auth::id())->exists();
            
            if (!$jaInscrita && !$aula->estaLotado()) {
                $aula->participantes()->attach(Auth::id());
                // Dispara evento para atualizar a interface se necessário
                $this->dispatch('inscricao-realizada'); 
            }
        }
    }

    // NOVA FUNÇÃO: Resolve o erro 403 baixando pelo PHP
    public function baixarMaterial($aulaId)
    {
        $aula = Event::find($aulaId);

        if ($aula && $aula->material_link) {
            // Se for link externo (Drive, etc), apenas redireciona
            if (strpos($aula->material_link, 'http') === 0 && strpos($aula->material_link, '/storage/') === false) {
                return redirect()->away($aula->material_link);
            }

            // Se for arquivo local (no storage), faz o download forçado
            // Remove o prefixo '/storage/' para pegar o caminho real no disco
            $path = str_replace('/storage/', '', parse_url($aula->material_link, PHP_URL_PATH));
            
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->download($path);
            } else {
                // Fallback: Tenta redirecionar se o arquivo não for encontrado no disco
                return redirect()->away($aula->material_link);
            }
        }
    }

    public function render()
    {
        // Busca as aulas da mentora para exibir na View
        // Ordena por data mais recente primeiro
        $aulasMentora = Event::where('user_id', $this->mentora->id)
            ->orderBy('data_hora', 'desc')
            ->take(5)
            ->get();

        return view('livewire.ver-mentora', [
            'aulasMentora' => $aulasMentora
        ])->layout('layouts.app');
    }
}