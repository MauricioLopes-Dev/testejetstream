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
    // 1. Tabela de Eventos
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quem criou (Mentora/Admin)
        $table->string('titulo');
        $table->text('descricao');
        $table->dateTime('data_hora');
        $table->string('local')->nullable(); // Link do Zoom ou Endereço
        $table->integer('limite_vagas')->default(0); // 0 = Ilimitado
        $table->timestamps();
    });

    // 2. Tabela Pivô (Quem se inscreveu em qual evento)
    Schema::create('event_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        // Garante que a usuária não se inscreva 2x no mesmo evento
        $table->unique(['event_id', 'user_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
