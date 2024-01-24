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
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('recibo', ['SI', 'NO']);
            $table->string('name_propietario');
            $table->string('ci_propietario');
            $table->string('relacion_propietario');
            $table->date('nacimiento_propietario');
            $table->string('telefono_propietario')->nullable();
            $table->string('celular_propietario');
            $table->string('email_propietario');
            $table->enum('envio_emailprincipal', ['SI', 'NO'])->nullable();
            $table->string('email_secundariopropietario')->nullable();
            $table->enum('envio_emailsecundario', ['SI', 'NO'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};
