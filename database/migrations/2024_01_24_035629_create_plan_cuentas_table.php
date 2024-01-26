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
        Schema::create('plan_cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('condominio_id')->constrained();
            $table->string('codigo');
            $table->string('nombre_cuenta');
            $table->enum(
                'grupo_contable',
                ['ACTIVO', 'PASIVO', 'PATRIMONIO', 'INGRESOS', 'EGRESOS', 'GASTOS']
            );
            $table->enum('cuenta_superior', ['0', '1'])->default('0');
            $table->integer('superior_id');
            $table->decimal('saldo_actual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plan_cuentas', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['condominio_id']);
        });

        Schema::dropIfExists('plan_cuentas');
    }
};
