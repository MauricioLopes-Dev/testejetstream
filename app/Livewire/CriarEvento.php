<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class CriarEvento extends Component
{
    public $titulo, $descricao, $data_hora, $data_fim, $local, $limite_vagas = 0;

    public function mount()
    {
        // CORREÇÃO 1: Verificar especificamente o guard 'admin'
        // O Auth::user() padrão busca alunas e retornaria erro aqui.
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado');
        }
    }

    public function salvar()
    {
        $this->validate([
            'titulo' => 'required|min:5',
            'data_hora' => 'required|date|after:today',
            'data_fim' => 'required|date|after:data_hora',
            'limite_vagas' => 'integer|min:0',
        ]);

        // CORREÇÃO 2: Pegar o ID do Admin corretamente
        // Se usar apenas Auth::id(), ele tenta pegar o ID de uma aluna.
        $adminId = Auth::guard('admin')->id();

        Event::create([
            'user_id' => $adminId, // Atenção: Certifique-se que seu BD aceita ID de admin aqui
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'data_hora' => $this->data_hora,
            'data_fim' => $this->data_fim,
            'local' => $this->local,
            'limite_vagas' => $this->limite_vagas,
        ]);

        session()->flash('message', 'Aula criada com sucesso! Agora você pode anexar o material.');
        
        // CORREÇÃO 3: Nome correto da rota conforme seu web.php
        // A rota lá está definida como 'admin.aulas.gerenciar'
        return redirect()->route('admin.aulas.gerenciar');
    }

    public function render()
    {
        // CORREÇÃO 4: Layout correto (isso você já tinha feito certo!)
        return view('livewire.criar-evento')->layout('layouts.admin');
    }
}