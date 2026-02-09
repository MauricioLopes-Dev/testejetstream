<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class VerifyEmailCode extends Component
{
    // Usamos um array para os 6 dígitos para facilitar a interface
    public $digits = ['', '', '', '', '', ''];
    public $code = '';

    public function updatedDigits()
    {
        // Sempre que um dígito mudar, atualizamos a string completa do código
        $this->code = implode('', $this->digits);
        
        // Se já tiver 6 dígitos, tenta validar automaticamente
        if (strlen($this->code) === 6) {
            $this->verify();
        }
    }

    public function verify()
    {
        $this->code = implode('', $this->digits);

        if (strlen($this->code) !== 6) {
            $this->addError('code', 'Por favor, insira os 6 dígitos.');
            return;
        }

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

        // Se o código estiver errado, limpa os campos e mostra erro
        $this->digits = ['', '', '', '', '', ''];
        $this->code = '';
        $this->addError('code', 'Código incorreto. Verifique seu e-mail e tente novamente.');
    }

    public function render()
    {
        return view('livewire.verify-email-code');
    }
}
