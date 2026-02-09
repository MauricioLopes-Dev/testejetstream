<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VerifyEmailCode extends Component
{
    public $code;

    protected $rules = [
        'code' => 'required|string|size:6',
    ];

    public function verify()
    {
        $this->validate();

        $user = Auth::user();

        // Verifica se o código digitado é igual ao código salvo no banco
        if ($user->verification_code === $this->code) {
            // Marca o e-mail como verificado
            $user->markEmailAsVerified();
            
            // Limpa o código para segurança
            $user->verification_code = null;
            $user->save();

            // Redireciona para o dashboard
            return redirect()->intended(config('fortify.home'));
        }

        // Se o código estiver errado, adiciona um erro
        $this->addError('code', 'O código de verificação está incorreto.');
    }

    public function render()
    {
        return view('livewire.verify-email-code');
    }
}
