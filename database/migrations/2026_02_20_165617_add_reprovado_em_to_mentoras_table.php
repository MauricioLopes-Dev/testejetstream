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
    Schema::table('mentoras', function (Blueprint $table) {
        // Só adiciona a coluna se ela não existir
        if (!Schema::hasColumn('mentoras', 'reprovado_em')) {
            $table->timestamp('reprovado_em')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('mentoras', function (Blueprint $table) {
        $table->dropColumn('reprovado_em');
    });
}
};
