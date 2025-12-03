<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Campo para definir o papel: 'admin', 'mentora', 'aluna'
        // Vamos deixar 'aluna' como padrão para quem se registrar
        $table->string('role')->default('aluna')->after('email');

        // Campos opcionais (nullable) pois a pessoa pode preencher depois
        $table->string('linkedin_url')->nullable()->after('role');
        $table->text('bio')->nullable()->after('linkedin_url'); // Texto longo para biografia
        $table->string('area_atuacao')->nullable()->after('bio'); // Ex: 'Dev Backend', 'Data Science'
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Se desfazermos a migration, removemos as colunas
        $table->dropColumn(['role', 'linkedin_url', 'bio', 'area_atuacao']);
    });
}
};
