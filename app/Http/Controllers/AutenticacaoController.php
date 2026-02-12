<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Mentora;
use App\Models\Admin;
use App\Models\AreaAtuacao;
use App\Notifications\MentoraVerificationCode;
use Carbon\Carbon;

class AutenticacaoController extends Controller
{
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function mostrarCadastro()
    {
        return view('auth.register_custom');
    }

    public function cadastrarAluna(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:mentoras|unique:admins',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $aluna = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($aluna);

        return redirect()->route('dashboard');
    }

    public function cadastrarMentora(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'telefone' => 'required|string',
            'area_atuacao_id' => 'required|exists:areas_atuacao,id',
            'nivel_experiencia' => 'required|in:estudante,junior,pleno,senior,lideranca',
        ]);

        // Verificação de travas (30 dias para reprovados)
        $bloqueio = Mentora::where(function($query) use ($request) {
            $query->where('email', $request->email)
                  ->orWhere('telefone', $request->telefone);
        })->where('status_aprovacao', 'reprovado')
          ->where('reprovado_em', '>', Carbon::now()->subDays(30))
          ->first();

        if ($bloqueio) {
            return back()->withErrors(['email' => 'Seu cadastro de mentoria foi reprovado, tente novamente em 30 dias após a reprovação.']);
        }

        // Verificação se já existe (não reprovado recentemente)
        $existente = Mentora::where('email', $request->email)->first();
        if ($existente) {
            if ($existente->status_aprovacao === 'aprovado') {
                return back()->withErrors(['email' => 'Você já é uma mentora, deseja logar?']);
            }
            if ($existente->status_aprovacao === 'pendente') {
                return back()->withErrors(['email' => 'Seu cadastro de mentoria está sendo analisado.']);
            }
        }

        $codigo = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $mentora = Mentora::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefone' => $request->telefone,
            'area_atuacao_id' => $request->area_atuacao_id,
            'nivel_experiencia' => $request->nivel_experiencia,
            'github_url' => $request->github_url,
            'linkedin_url' => $request->linkedin_url,
            'sobre_mim' => $request->sobre_mim,
            'codigo_verificacao' => $codigo,
            'status_aprovacao' => 'pendente',
        ]);

        $mentora->notify(new MentoraVerificationCode($codigo));
        
        return redirect()->route('mentora.verificacao', ['email' => $mentora->email])
                         ->with('info', 'Verifique seu e-mail para validar sua conta.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'tipo' => 'required|in:aluna,mentora,admin',
        ]);

        $credentials = $request->only('email', 'password');
        $tipo = $request->tipo;
        $guard = ($tipo === 'aluna') ? 'web' : $tipo;

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();

            if ($tipo === 'mentora') {
                $mentora = Auth::guard('mentora')->user();
                
                if (!$mentora->email_verificado_at) {
                    return redirect()->route('mentora.verificacao', ['email' => $mentora->email]);
                }

                if ($mentora->status_aprovacao === 'pendente') {
                    Auth::guard('mentora')->logout();
                    return back()->withErrors(['email' => 'Seu cadastro de mentoria está sendo analisado.']);
                }

                if ($mentora->status_aprovacao === 'reprovado') {
                    if ($mentora->reprovado_em && $mentora->reprovado_em->diffInDays(now()) < 30) {
                        Auth::guard('mentora')->logout();
                        return back()->withErrors(['email' => 'Seu cadastro de mentoria foi reprovado, tente novamente em 30 dias após a reprovação.']);
                    }
                }
            }

            return redirect()->intended($tipo === 'admin' ? '/admin/dashboard' : ($tipo === 'mentora' ? '/mentora/dashboard' : '/dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required|string|size:6',
        ]);

        $mentora = Mentora::where('email', $request->email)
                          ->where('codigo_verificacao', $request->codigo)
                          ->first();

        if (!$mentora) {
            return back()->withErrors(['codigo' => 'Código de verificação inválido.']);
        }

        $mentora->update([
            'codigo_verificacao' => null,
            'email_verificado_at' => now(),
        ]);

        return redirect('/')->with('success_box', 'Cadastro enviado com sucesso! Será analisado e você será informada pelo e-mail o resultado.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
