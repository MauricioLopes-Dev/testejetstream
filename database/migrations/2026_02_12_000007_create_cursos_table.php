<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->foreignId('area_atuacao_id')->nullable()->constrained('areas_atuacao')->onDelete('set null');
            $table->string('area_personalizada')->nullable(); // Para quando selecionar "Outro"
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->foreignId('mentora_id')->nullable()->constrained('mentoras')->onDelete('set null');
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Tabela de aulas do curso
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('tipo')->default('video'); // video, pdf, link_meet, texto
            $table->text('conteudo')->nullable(); // URL do vídeo, PDF, link do Meet, ou texto
            $table->integer('ordem')->default(0);
            $table->dateTime('data_aula')->nullable(); // Para aulas ao vivo
            $table->timestamps();
        });

        // Tabela de inscrições em cursos
        Schema::create('curso_inscricoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('inscrito_em')->useCurrent();
            $table->unique(['curso_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curso_inscricoes');
        Schema::dropIfExists('aulas');
        Schema::dropIfExists('cursos');
    }
};
