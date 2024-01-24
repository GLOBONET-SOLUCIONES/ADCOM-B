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
        Schema::create('inmuebles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('name_inmueble');
            $table->foreignId('condominio_id')->constrained();
            $table->integer('plantas');
            $table->decimal('alicuotas');
            $table->decimal('expensas');
            $table->foreignId('propietario_id')->constrained();
            $table->foreignId('residente_id')->constrained();
            $table->date('fecha_entrega');
            $table->enum('es_residente', ['SI', 'NO'])->default('NO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inmuebles', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['condominio_id']);
            $table->dropForeign(['propietario_id']);
            $table->dropForeign(['residente_id']);
        });

        Schema::dropIfExists('inmuebles');
    }
};
