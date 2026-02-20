<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

class CriarHistoria extends Component
{
    public $titulo, $subtitulo, $conteudo, $imagem_capa;
    
    // Propriedade para identificar quem está logado
    public $currentGuard;

    public function mount()
    {
        // 1. Detecta o guard correto (Admin ou Mentora)
        if (Auth::guard('admin')->check()) {
            $this->currentGuard = 'admin';
        } elseif (Auth::guard('mentora')->check()) {
            $this->currentGuard = 'mentora';
        } else {
            // Se for aluna ou não estiver logado, bloqueia
            abort(403, 'Acesso não autorizado. Apenas Admins ou Mentoras podem postar.');
        }
    }

    public function salvar()
    {
        $this->validate([
            'titulo' => 'required|min:5',
            'subtitulo' => 'required|max:255',
            'conteudo' => 'required|min:20',
            'imagem_capa' => 'nullable|url',
        ]);

        // 2. Pega o ID do usuário baseado no Guard atual
        $userId = Auth::guard($this->currentGuard)->id();

        Story::create([
            'user_id' => $userId,
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'conteudo' => $this->conteudo,
            'imagem_capa' => $this->imagem_capa,
        ]);

        session()->flash('message', 'História publicada com sucesso! ✨');

        // 3. Redirecionamento condicional
        // Redirecionamos para o dashboard pois a rota 'blog.index' é exclusiva para Alunas
        if ($this->currentGuard === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($this->currentGuard === 'mentora') {
            return redirect()->route('mentora.dashboard');
        }

        return redirect()->back();
    }

    public function render()
    {
        // 4. Define o layout dinamicamente
        $layout = $this->currentGuard === 'admin' ? 'layouts.admin' : 'layouts.mentora';

        return view('livewire.criar-historia')->layout($layout);
    }
}