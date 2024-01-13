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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ci_ruc');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->enum('obligado', ['SI', 'NO']);
            $table->string('ruc_contador')->nullable();
            $table->string('nombre_contador')->nullable();
            $table->integer('lim_condominios');
            $table->integer('lim_subusuarios');
            $table->string('plan');
            $table->integer('plan_act');
            $table->integer('plan_ant')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
