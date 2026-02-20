<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class GerenciarDepoimentos extends Component
{
    // Propriedades para o formulário
    public $name;
    public $role;
    public $content;
    public $photo_url;

    // Garante que apenas Admins acessem este componente
    public function mount()
    {
        // CORREÇÃO 1: Verifica explicitamente o guard 'admin'
        // Auth::user() buscaria no guard 'web' (alunas) e retornaria null aqui.
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado. Apenas administradores.');
        }
    }

    // Função para salvar um novo depoimento
    public function salvar()
    {
        // 1. Validação dos dados
        $this->validate([
            'name' => 'required|min:3|max:255',
            'role' => 'required|min:3|max:255',
            'content' => 'required|min:10|max:500',
            'photo_url' => 'nullable|url', // Opcional, mas se tiver, deve ser URL válida
        ]);

        // 2. Criação no Banco de Dados
        Testimonial::create([
            'name' => $this->name,
            'role' => $this->role,
            'content' => $this->content,
            'photo_url' => $this->photo_url,
            'is_active' => true, // Ativo por padrão
        ]);

        // 3. Limpa o formulário e avisa
        $this->reset(['name', 'role', 'content', 'photo_url']);
        session()->flash('message', 'Depoimento adicionado com sucesso!');
    }

    // Função para apagar um depoimento
    public function deletar($id)
    {
        // Verificação de segurança adicional
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }

        $depoimento = Testimonial::find($id);
        
        if ($depoimento) {
            $depoimento->delete();
            session()->flash('message', 'Depoimento removido.');
        }
    }

    public function render()
    {
        // Busca os depoimentos mais recentes para mostrar na lista abaixo do formulário
        $depoimentos = Testimonial::latest()->get();

        return view('livewire.gerenciar-depoimentos', [
            'depoimentos' => $depoimentos
        ])->layout('layouts.admin'); // CORREÇÃO 2: Usa o layout do painel administrativo
    }
}