<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('evento_publicos', function (Blueprint $table) {
            $table->dropColumn('imagem_path'); // Remove a coluna de foto única
            $table->json('midias')->nullable(); // Cria a coluna que aceita várias fotos/vídeos
        });
    }
};