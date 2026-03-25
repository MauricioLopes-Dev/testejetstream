<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Adicionar campos de vagas e duração na tabela cursos
        Schema::table('cursos', function (Blueprint $table) {
            $table->integer('max_vagas')->default(30)->after('ativo');
            $table->integer('duracao_horas')->nullable()->after('max_vagas'); // Duração total em horas
            $table->text('imagem_capa')->nullable()->after('duracao_horas');
        });

        // Tabela pivot para múltiplas mentoras por curso
        Schema::create('curso_mentora', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->foreignId('mentora_id')->constrained('mentoras')->onDelete('cascade');
            $table->unique(['curso_id', 'mentora_id']);
            $table->timestamps();
        });

        // Tabela de Matérias (disciplinas dentro de um curso)
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        // Tabela de Materiais Didáticos (conteúdos dentro de uma matéria)
        Schema::create('materiais_didaticos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('mentora_id')->nullable()->constrained('mentoras')->onDelete('set null');
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['video', 'pdf', 'documento', 'link', 'texto'])->default('texto');
            $table->text('conteudo')->nullable(); // URL, texto ou caminho do arquivo
            $table->string('arquivo_path')->nullable(); // Caminho do arquivo uploaded
            $table->string('arquivo_nome')->nullable(); // Nome original do arquivo
            $table->integer('ordem')->default(0);
            $table->timestamps();
        });

        // Adicionar timestamps na tabela curso_inscricoes se não existir
        if (!Schema::hasColumn('curso_inscricoes', 'created_at')) {
            Schema::table('curso_inscricoes', function (Blueprint $table) {
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('materiais_didaticos');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('curso_mentora');

        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['max_vagas', 'duracao_horas', 'imagem_capa']);
        });
    }
};
