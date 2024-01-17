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
            $table->integer('admin_id');
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('role_id')->constrained();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('en_condominios')->nullable();
            $table->string('en_inmuebles')->nullable();
            $table->string('perm_modulos')->nullable();
            $table->string('perm_acciones')->nullable();
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
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['plan_id']);
            $table->dropForeign(['role_id']);
        });

        Schema::dropIfExists('users');
    }
};
