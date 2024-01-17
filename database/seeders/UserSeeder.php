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
            'email' => 'admin@admin.com',
            'plan_id' => '1',
            'admin_id' => '1',
            'role_id' => '1',
            'en_condominios' => null,
            'en_inmuebles' => null,
            'perm_modulos' => null,
            'perm_acciones' => null,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ])->assignRole('SuperAdmin');
    }
}
