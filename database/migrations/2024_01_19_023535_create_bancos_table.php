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
        Schema::create('bancos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('condominio_id')->constrained();
            $table->date('fecha_registro')->nullable();
            $table->string('banco')->nullable();
            $table->string('cuenta')->nullable();
            $table->decimal('saldo_inicial')->nullable();
            $table->enum('predeterminado', ['SI', 'NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bancos', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['condominio_id']);
        });

        Schema::dropIfExists('bancos');
    }
};
