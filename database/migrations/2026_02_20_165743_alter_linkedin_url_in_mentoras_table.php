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
    Schema::table('mentoras', function (Blueprint $table) {
        $table->text('linkedin_url')->change();
    });
}

public function down(): void
{
    Schema::table('mentoras', function (Blueprint $table) {
        $table->string('linkedin_url', 255)->change();
    });
}
};
