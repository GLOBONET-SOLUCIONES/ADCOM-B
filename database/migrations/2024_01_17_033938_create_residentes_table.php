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
        Schema::create('residentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('recibo', ['SI', 'NO']);
            $table->string('name_residente');
            $table->string('ci_residente');
            $table->string('relacion_residente');
            $table->date('nacimiento_residente');
            $table->string('telefono_residente')->nullable();
            $table->string('celular_residente');
            $table->string('email_residente');
            $table->enum('envio_emailprincipal', ['SI', 'NO'])->nullable();
            $table->string('email_secundarioresidente')->nullable();
            $table->enum('envio_emailsecundario', ['SI', 'NO'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('residentes');
    // }
};
