<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\MensagemChat;
use App\Models\Mentora;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatDuvidas extends Component
{
    public $mentoraId;
    public $alunaId;
    public $mensagem = '';
    public $tipoUsuario; // 'aluna' ou 'mentora'
    public $interlocutor;

    public function mount($mentoraId = null, $alunaId = null)
    {
        if (Auth::guard('mentora')->check()) {
            $this->tipoUsuario = 'mentora';
            $this->mentoraId = Auth::guard('mentora')->id();
            $this->alunaId = $alunaId;
            
            if ($this->alunaId) {
                $aluna = User::find($this->alunaId);
                $this->interlocutor = $aluna ? $aluna->name : 'Aluna';
            }
        } else {
            $this->tipoUsuario = 'aluna';
            $this->alunaId = Auth::id();
            $this->mentoraId = $mentoraId;
            
            if ($this->mentoraId) {
                $mentora = Mentora::find($this->mentoraId);
                $this->interlocutor = $mentora ? $mentora->nome : 'Mentora';
            }
        }
    }

    public function enviarMensagem()
    {
        $this->validate([
            'mensagem' => 'required|string|max:1000',
        ]);

        MensagemChat::create([
            'mentora_id' => $this->mentoraId,
            'user_id' => $this->alunaId,
            'mensagem' => $this->mensagem,
            'remetente' => $this->tipoUsuario,
        ]);

        $this->mensagem = '';
        $this->dispatch('mensagemEnviada');
    }

    public function render()
    {
        $mensagens = MensagemChat::where('mentora_id', $this->mentoraId)
            ->where('user_id', $this->alunaId)
            ->orderBy('created_at', 'asc')
            ->get();

        $layout = $this->tipoUsuario === 'mentora' ? 'layouts.mentora' : 'layouts.app';

        return view('livewire.chat-duvidas', [
            'mensagens' => $mensagens,
            'interlocutor' => $this->interlocutor
        ])->layout($layout);
    }
}
