<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Usuarios
            'ver-usuarios',
            'crear-usuario',
            'store-usuario',
            'ver-usuario',
            'editar-usuario',
            'actualizar-usuario',
            'modificar-usuario',
            'guardar-usuario',
            'borrar-usuario',
            'restaurar-usuario',
            'eliminar-usuarios',
            // Pacientes
            'ver-pacientes',
            'crear-pacientes',
            'store-pacientes',
            'ver-paciente',
            'editar-pacientes',
            'actualizar-pacientes',
            'borrar-pacientes',
            'restaurar-pacientes',
            'eliminar-pacientes',
            'solicitar-dosis',
            'aprobar-dosis',
            'solicitar-direccion',
            'aprobar-direccion',
            'abrir-incidencia',
            'dar-alta',
            // Roles y Permisos
            'ver-roles',
            'crear-roles',
            'store-roles',
            'ver-rol',
            'editar-roles',
            'actualizar-roles',
            'borrar-roles',
            'restaurar-roles',
            'eliminar-roles',
            'ver-permisos',
            'crear-permisos',
            'store-permisos',
            'ver-permiso',
            'editar-permisos',
            'actualizar-permisos',
            'borrar-permisos',
            'restaurar-permisos',
            'eliminar-permisos'
        ];

        foreach ($permissions as $perm) {
            try {
                Permission::create(['name' => $perm]);
            } catch (\Spatie\Permission\Exceptions\PermissionAlreadyExists $e) {
                // si el permiso ya existe, no hace nada y continua el ciclo
            }
        }

        $roles = [
            'SuperAdmin',
            'Dueño',
            'Administrador',
            'Gerencia',
            'Hospitales',
            'Medicos'
        ];

        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);
            if (in_array($roleName, ['SuperAdmin', 'Dueño', 'Administrador'])) {
                $role->givePermissionTo(Permission::all());
            }
        }

        $usuario = User::query()->find(1);
        if ($usuario) {
            $usuario->assignRole('SuperAdmin');
        }
        $usuario = User::query()->find(2);
        if ($usuario) {
            $usuario->assignRole('Administrador');
        }
        $usuario = User::query()->find(3);
        if ($usuario) {
            $usuario->assignRole('Gerencia');
        }
        $usuario = User::query()->find(4);
        if ($usuario) {
            $usuario->assignRole('Hospitales');
        }
        $usuario = User::query()->find(5);
        if ($usuario) {
            $usuario->assignRole('Hospitales');
        }
        // asignar roles a usuarios del 6 en adelante
        $usuarios = User::query()->where('id', '>=', 6)->get();
        foreach ($usuarios as $usuario) {
            $Hospital = $usuario->hospital;
            if ($Hospital->parent_id == null) {
                $usuario->assignRole('Gerencia');
            } elseif ($Hospital->parent_id != null) {
                $usuariosHospital = User::query()->where('hospital_id', $Hospital->id)->get();
                if ($usuariosHospital->count() == 1) {
                    $usuario->assignRole('Hospitales');
                } else {
                    $usuario->assignRole('Medicos');
                }
            }
        }
    }
}
