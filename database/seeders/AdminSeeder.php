<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team; // <--- Importante: Adicionar isso!
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar o Usuário
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@projeto.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Conta de administração principal.',
            'area_atuacao' => 'Gestão',
            // O campo current_team_id ficará vazio por enquanto
        ]);

        // 2. Criar um Time Pessoal para ele (Obrigatório no modo Teams)
        $team = Team::forceCreate([
            'user_id' => $user->id,
            'name' => 'Time Administrativo',
            'personal_team' => true,
        ]);

        // 3. Definir esse time como o time atual do usuário
        $user->forceFill([
            'current_team_id' => $team->id,
        ])->save();
        
        $this->command->info('Usuário Admin e Time criados com sucesso!');
    }
}