<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;

class CriarHistoria extends Component
{
    public $titulo, $subtitulo, $conteudo, $imagem_capa;

    public function mount()
    {
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado');
        }
    }

    public function salvar()
    {
        $this->validate([
            'titulo' => 'required|min:5',
            'subtitulo' => 'required|max:255',
            'conteudo' => 'required|min:20',
            'imagem_capa' => 'nullable|url', // Por enquanto vamos usar URLs de imagens da internet
        ]);

        Story::create([
            'user_id' => Auth::id(),
            'titulo' => $this->titulo,
            'subtitulo' => $this->subtitulo,
            'conteudo' => $this->conteudo,
            'imagem_capa' => $this->imagem_capa,
        ]);

        session()->flash('message', 'História publicada com sucesso! ✨');
        return redirect()->route('blog.index'); // Criaremos essa rota no próximo passo
    }

    public function render()
    {
        return view('livewire.criar-historia')->layout('layouts.admin');
    }
}