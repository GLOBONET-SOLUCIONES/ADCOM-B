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
        Schema::create('tres_publicidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('publicidad_1');
            $table->string('publicidad_2')->nullable();
            $table->string('publicidad_3')->nullable();
            $table->string('publicidad_4')->nullable();
            $table->string('publicidad_5')->nullable();
            $table->integer('tiempo_publicidad')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tres_publicidades', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('tres_publicidades');
    }
};
