<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mentora;
use App\Models\User;
use App\Notifications\MentoraAprovada;
use App\Notifications\MentoraReprovada;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $mentorasPendentes = Mentora::where('status_aprovacao', 'pendente')
                                    ->whereNotNull('email_verificado_at')
                                    ->get();
        $totalAlunas = User::count();
        $totalMentoras = Mentora::where('status_aprovacao', 'aprovado')->count();

        return view('admin.dashboard_content', compact('mentorasPendentes', 'totalAlunas', 'totalMentoras'));
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
}
