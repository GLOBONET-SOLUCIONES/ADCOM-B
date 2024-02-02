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

        // Permisos Condominios (Propiedades)
        Permission::create(['name' => 'listar_propiedades'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_propiedades'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_propiedades'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_propiedades'])->syncRoles([$superadmin, $admin]);

        // Permisos Relaciones Familiares
        Permission::create(['name' => 'listar_relaciones_familiares'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_relaciones_familiares'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_relaciones_familiares'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_relaciones_familiares'])->syncRoles([$superadmin, $admin]);

        // Permisos Secuenciales de Documentos
        Permission::create(['name' => 'listar_secuenciales_documentos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_secuenciales_documentos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_secuenciales_documentos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_secuenciales_documentos'])->syncRoles([$superadmin, $admin]);

        // Permisos Firma Administradores
        Permission::create(['name' => 'listar_firma_admin'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_firma_admin'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_firma_admin'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_firma_admin'])->syncRoles([$superadmin, $admin]);

        // Permisos Presidentes y Tesoreros
        Permission::create(['name' => 'listar_presidentes_tesoreros'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_presidentes_tesoreros'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_presidentes_tesoreros'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_presidentes_tesoreros'])->syncRoles([$superadmin, $admin]);

        // Permisos Bancos
        Permission::create(['name' => 'listar_bancos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_bancos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_bancos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_bancos'])->syncRoles([$superadmin, $admin]);

        // Permisos Areas Comunales
        Permission::create(['name' => 'listar_areas_comunales'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_areas_comunales'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_areas_comunales'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_areas_comunales'])->syncRoles([$superadmin, $admin]);

        // Permisos Firma Administradores Email
        Permission::create(['name' => 'listar_firma_admin_email'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_firma_admin_email'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_firma_admin_email'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_firma_admin_email'])->syncRoles([$superadmin, $admin]);

        // Permisos Inmuebles
        Permission::create(['name' => 'listar_inmuebles'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_inmuebles'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_inmuebles'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_inmuebles'])->syncRoles([$superadmin, $admin]);

        // Permisos Plan de Cuentas
        Permission::create(['name' => 'listar_plan_cuentas'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_plan_cuentas'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_plan_cuentas'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_plan_cuentas'])->syncRoles([$superadmin, $admin]);

        // Permisos Proveedores
        Permission::create(['name' => 'listar_proveedores'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_proveedores'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_proveedores'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_proveedores'])->syncRoles([$superadmin, $admin]);

        // Permisos Empleados
        Permission::create(['name' => 'listar_empleados'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_empleados'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_empleados'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_empleados'])->syncRoles([$superadmin, $admin]);

        // Permisos Usuarios del Sistema
        Permission::create(['name' => 'listar_usuarios'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_usuarios'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_usuarios'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_usuarios'])->syncRoles([$superadmin, $admin]);

        // Permisos Facturacion Electronica (Estab, Puntos y Secuencias)
        Permission::create(['name' => 'listar_establecimientos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'crear_establecimientos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'editar_establecimientos'])->syncRoles([$superadmin, $admin]);
        Permission::create(['name' => 'eliminar_establecimientos'])->syncRoles([$superadmin, $admin]);
    }
}
