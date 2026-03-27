<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('evento_publicos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descricao')->nullable();
        $table->string('imagem_path'); // Para salvar o caminho da foto
        $table->date('data_realizacao'); // Quando o evento aconteceu
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_publicos');
    }
};
