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
        Schema::create('facturacion_secuencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('condominio_id')->constrained();
            $table->string('establecimiento', 3);
            $table->string('punto_emision', 3);
            $table->string('sec_factura', 9);
            $table->string('sec_retencion', 9);
            $table->string('sec_nota_credito', 9);
            $table->string('sec_nota_debito', 9);
            $table->string('sec_guia_remision', 9);
            $table->string('sec_liquidacion_compra', 9);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturacion_secuencias', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['condominio_id']);
        });

        Schema::dropIfExists('facturacion_secuencias');
    }
};
