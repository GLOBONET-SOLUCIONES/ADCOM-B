<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = Role::create(['name' => 'SuperAdmin']);
        $admin = Role::create(['name' => 'Admin']);
        $subusuario = Role::create(['name' => 'Subusuario']);

        // Register
        Permission::create(['name' => 'register'])->syncRoles([$superadmin]);

        // Permisos
        Permission::create(['name' => 'listar'])->syncRoles([$superadmin]);
        Permission::create(['name' => 'crear'])->syncRoles([$superadmin]);
        Permission::create(['name' => 'editar'])->syncRoles([$superadmin]);
        Permission::create(['name' => 'eliminar'])->syncRoles([$superadmin]);
    }
}
