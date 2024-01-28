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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('condominio_id')->constrained();
            $table->string('ci_ruc');
            $table->string('apellido');
            $table->string('name');
            $table->string('calle_principal');
            $table->string('numero');
            $table->string('calle_secundaria')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_inactivo')->nullable();
            $table->enum('inactivo', ['SI', 'NO'])->default('NO');
            $table->longText('motivo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['condominio_id']);
        });

        Schema::dropIfExists('empleados');
    }
};
