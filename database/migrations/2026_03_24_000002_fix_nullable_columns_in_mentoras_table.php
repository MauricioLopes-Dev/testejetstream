<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Corrige colunas opcionais que perderam o nullable após alterações anteriores.
     */
    public function up(): void
    {
        Schema::table('mentoras', function (Blueprint $table) {
            $table->text('linkedin_url')->nullable()->change();
            $table->string('github_url')->nullable()->change();
            $table->text('sobre_mim')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('mentoras', function (Blueprint $table) {
            $table->text('linkedin_url')->nullable(false)->change();
            $table->string('github_url')->nullable(false)->change();
            $table->text('sobre_mim')->nullable(false)->change();
        });
    }
};
