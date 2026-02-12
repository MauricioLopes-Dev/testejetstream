<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas_atuacao', function (Blueprint $column) {
            $column->id();
            $column->string('nome');
            $column->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('areas_atuacao');
    }
};
