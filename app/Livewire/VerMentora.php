<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Solicitacao;
use App\Models\Event; // <--- Importação necessária para manipular eventos
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSolicitacaoMentoria;
use Illuminate\Support\Facades\Log;

class VerMentora extends Component
{
    public User $mentora;
    public $statusSolicitacao = null; // null, 'pendente', 'aceito', 'recusado'

    public function mount($id)
    {
        $this->mentora = User::findOrFail($id);
        
        if ($this->mentora->role !== 'mentora') { abort(404); }

        // Busca a solicitação MAIS RECENTE
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
        set_time_limit(120); // Aumenta timeout para envio de e-mail

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

    // NOVA FUNÇÃO: Inscrever na aula diretamente
    public function inscreverAula($aulaId)
    {
        $aula = Event::find($aulaId);
        
        if ($aula) {
            // Verifica se já está inscrita
            $jaInscrita = $aula->participantes()->where('user_id', Auth::id())->exists();
            
            // Só inscreve se não estiver inscrita e não estiver lotado
            if (!$jaInscrita && !$aula->estaLotado()) {
                $aula->participantes()->attach(Auth::id());
                
                // O Livewire automaticamente atualiza a View, então o botão mudará para "Inscrita"
            }
        }
    }

    public function render()
    {
        return view('livewire.ver-mentora')->layout('layouts.app');
    }
}