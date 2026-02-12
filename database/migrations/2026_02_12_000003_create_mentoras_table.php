<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentoras', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefone');
            $table->foreignId('area_atuacao_id')->constrained('areas_atuacao');
            $table->enum('nivel_experiencia', ['estudante', 'junior', 'pleno', 'senior', 'lideranca']);
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('sobre_mim')->nullable();
            
            // Verificação e Aprovação
            $table->string('codigo_verificacao')->nullable();
            $table->timestamp('email_verificado_at')->nullable();
            $table->enum('status_aprovacao', ['pendente', 'aprovado', 'reprovado'])->default('pendente');
            $table->timestamp('reprovado_em')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentoras');
    }
};
