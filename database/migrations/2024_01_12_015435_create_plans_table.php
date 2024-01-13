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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('nombre');
            $table->enum('licencia', ['Mensual', 'Anual', 'Permanente']);
            $table->decimal('precio');
            $table->integer('lim_condominios');
            $table->integer('lim_subusuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('plans');
    }
};
