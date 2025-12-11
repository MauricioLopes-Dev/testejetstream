<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Solicitacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NovaSolicitacaoMentoria;
use Illuminate\Support\Facades\Log; // Importante para logar erros

class VerMentora extends Component
{
    public User $mentora;
    public $solicitacaoEnviada = false;

    public function mount($id)
    {
        $this->mentora = User::findOrFail($id);
        
        if ($this->mentora->role !== 'mentora') { abort(404); }

        $jaSolicitou = Solicitacao::where('mentora_id', $this->mentora->id)
            ->where('aluna_id', Auth::id())
            ->exists();

        if ($jaSolicitou) {
            $this->solicitacaoEnviada = true;
        }
    }

    public function solicitarMentoria()
    {
        // Aumenta o tempo limite do script para 120 segundos (2 minutos)
        // Isso evita o erro "Maximum execution time of 30 seconds exceeded"
        set_time_limit(120);

        if (Auth::id() === $this->mentora->id) {
            return;
        }

        // 1. Cria no Banco
        $solicitacao = Solicitacao::create([
            'mentora_id' => $this->mentora->id,
            'aluna_id' => Auth::id(),
            'status' => 'pendente'
        ]);

        // 2. Tenta enviar o E-mail
        try {
            Mail::to($this->mentora->email)->send(new NovaSolicitacaoMentoria($solicitacao));
        } catch (\Throwable $e) {
            // Usamos \Throwable para capturar qualquer erro, inclusive timeouts
            // O sistema não vai travar na tela da usuária, mas vai salvar o erro no log
            Log::error('Erro crítico ao enviar email de mentoria: ' . $e->getMessage());
            
            // Opcional: Você pode adicionar um aviso visual se quiser, 
            // mas aqui deixamos prosseguir para não frustrar a usuária já que o pedido foi salvo no banco.
        }

        $this->solicitacaoEnviada = true;
    }

    public function render()
    {
        return view('livewire.ver-mentora')->layout('layouts.app');
    }
}