<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tenta encontrar pelo email. Se não achar, CRIA.
        $user = User::firstOrCreate(
            ['email' => 'admin@projeto.com'], // Busca por este campo
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'bio' => 'Administradora Geral',
                'area_atuacao' => 'Gestão',
                'email_verified_at' => now(),
            ]
        );

        // 2. Garante o Time (Só cria se não tiver)
        if (!$user->personalTeam()) {
            $team = Team::forceCreate([
                'user_id' => $user->id,
                'name' => 'Time Administrativo',
                'personal_team' => true,
            ]);

            $user->forceFill(['current_team_id' => $team->id])->save();
        }
        
        $this->command->info('Admin verificado/criado com sucesso.');
    }
}