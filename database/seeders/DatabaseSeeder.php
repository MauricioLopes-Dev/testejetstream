<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // REMOVIDO: O código que criava o 'test@example.com' foi apagado para não dar erro de duplicidade.

        // ADICIONADO: Chamamos os nossos seeders personalizados
        // Eles são inteligentes e só criam se não existir (graças ao firstOrCreate que usamos neles)
        $this->call([
            AdminSeeder::class,
            MentorasSeeder::class,
        ]);
    }
}