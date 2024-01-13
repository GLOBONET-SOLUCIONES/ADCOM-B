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
        Schema::create('condominios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('ruc_condominio')->unique();
            $table->string('name_condominio');
            $table->string('cod_condominio');
            $table->string('calle_principal');
            $table->string('numeracion');
            $table->string('calle_secundaria')->nullable();
            $table->string('sector');
            $table->string('telefono');
            $table->string('ciudad');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('condominios', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('condominios');
    }
};
