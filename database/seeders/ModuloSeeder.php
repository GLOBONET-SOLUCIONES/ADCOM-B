<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('modulos')->insert([
            'modulo' => 'administracion',
        ]);

        DB::table('modulos')->insert([
            'modulo' => 'finanzas',
        ]);

        DB::table('modulos')->insert([
            'modulo' => 'comunicaciones',
        ]);

        DB::table('modulos')->insert([
            'modulo' => 'reportes',
        ]);
    }
}
