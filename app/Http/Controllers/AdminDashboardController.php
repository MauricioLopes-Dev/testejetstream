<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentora;
use App\Models\User;
use App\Notifications\MentoraAprovada;
use App\Notifications\MentoraReprovada;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $mentorasPendentes = Mentora::where('status_aprovacao', 'pendente')
                                    ->whereNotNull('email_verificado_at')
                                    ->get();
        $totalAlunas = User::count();
        $totalMentoras = Mentora::where('status_aprovacao', 'aprovado')->count();

        return view('admin.dashboard', compact('mentorasPendentes', 'totalAlunas', 'totalMentoras'));
    }

    public function aprovar($id)
    {
        $mentora = Mentora::findOrFail($id);
        $mentora->update(['status_aprovacao' => 'aprovado']);
        
        $mentora->notify(new MentoraAprovada());

        return back()->with('status', 'Mentora aprovada com sucesso!');
    }

    public function reprovar($id)
    {
        $mentora = Mentora::findOrFail($id);
        $mentora->update([
            'status_aprovacao' => 'reprovado',
            'reprovado_em' => now()
        ]);
        
        $mentora->notify(new MentoraReprovada());

        return back()->with('status', 'Mentora reprovada. Ela poderá tentar novamente em 30 dias.');
    }

    public function perfil()
    {
        return view('admin.perfil');
    }

    public function alterarSenha(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('status', 'Senha alterada com sucesso!');
    }
}
// Sincronização Forçada v2
