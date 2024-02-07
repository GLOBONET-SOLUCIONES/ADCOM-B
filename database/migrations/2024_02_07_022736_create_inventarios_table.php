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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('codigo');
            $table->string('name');
            $table->string('marca')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->string('stock')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('inventarios', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('inventarios');
    }
};
