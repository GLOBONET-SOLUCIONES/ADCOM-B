<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'SuperAdmin',
            'ci_ruc' => '1234567890',
            'email' => 'admin@admin.com',
            'telefono' => '0987654321',
            'obligado' => 'NO',
            'ruc_contador' => null,
            'nombre_contador' => null,
            'lim_condominios' => '10000000',
            'lim_subusuarios' => '10000000',
            'plan_ant' => '1',
            'plan' => 'Anual',
            'plan_act' => '1',
            'fecha_inicio' => now(),
            'fecha_final' => Carbon::parse(now())->addYear(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ])->assignRole('SuperAdmin');
    }
}
