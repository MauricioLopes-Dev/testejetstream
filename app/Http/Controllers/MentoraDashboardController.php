<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MentoraDashboardController extends Controller
{
    public function dashboard()
    {
        $mentora = Auth::guard('mentora')->user();
        $cursos = $mentora->cursos()->get();
        
        return view('mentora.dashboard', [
            'totalCursos' => $cursos->count(),
            'cursos' => $cursos,
        ]);
    }

    public function eventos()
    {
        return view('mentora.eventos');
    }

    public function cursos()
    {
        $mentora = Auth::guard('mentora')->user();
        $cursos = $mentora->cursos()->with('aulas')->get();
        
        return view('mentora.cursos', [
            'cursos' => $cursos,
        ]);
    }
}
