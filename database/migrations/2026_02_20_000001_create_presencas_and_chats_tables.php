<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela de presença nas aulas
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aula_id')->constrained('aulas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('presente')->default(false);
            $table->timestamps();
            $table->unique(['aula_id', 'user_id']);
        });

        // Tabela de chat/mensagens entre alunas e mentoras
        Schema::create('mensagens_chat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentora_id')->constrained('mentoras')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('mensagem');
            $table->enum('remetente', ['aluna', 'mentora']);
            $table->boolean('lida')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensagens_chat');
        Schema::dropIfExists('presencas');
    }
};
