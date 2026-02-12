<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaAtuacao;

class ProjetoEllasSeeder extends Seeder
{
    public function run(): void
    {
        \$areas = [
            'Banco de Dados',
            'Desenvolvimento Backend',
            'Desenvolvimento Frontend',
            'Desenvolvimento Fullstack',
            'Web Designer',
            'Pacote Office',
            'Outros'
        ];

        foreach (\$areas as \$area) {
            AreaAtuacao::firstOrCreate(['nome' => \$area]);
        }
    }
}
