<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Jetstream;

class MentorRegisterController extends Controller
{
    // Mostra o formulário de registro da mentora
    public function create()
    {
        return view('auth.register-mentor');
    }

    // Processa o envio do formulário
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            // Campos extras da mentora
            'area_atuacao' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'linkedin_url' => ['nullable', 'url'],
        ]);

        return DB::transaction(function () use ($request) {
            return tap(User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mentora', // <--- O PULO DO GATO: Já cria como mentora
                'area_atuacao' => $request->area_atuacao,
                'bio' => $request->bio,
                'linkedin_url' => $request->linkedin_url,
                'solicitou_mentoria' => false,
            ]), function (User $user) {
                
                // Cria o Time Pessoal (Obrigatório no Jetstream)
                $this->createTeam($user);

                // Loga a usuária e redireciona
                Auth::login($user);
            });
        });

        return redirect(route('dashboard'));
    }

    // Função auxiliar para criar o time (padrão do Jetstream)
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}