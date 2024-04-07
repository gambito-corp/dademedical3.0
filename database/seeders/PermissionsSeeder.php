<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
//            Usuarios
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
//            Roles
//            'ver-roles',
//            'crear-roles',
//            'store-roles',
//            'ver-rol',
//            'editar-roles',
//            'actualizar-roles',
//            'borrar-roles',
//            'restaurar-roles',
//            'eliminar-roles',
//            Permisos
//            'ver-permisos',
//            'crear-permisos',
//            'store-permisos',
//            'ver-permiso',
//            'editar-permisos',
//            'actualizar-permisos',
//            'borrar-permisos',
//            'restaurar-permisos',
//            'eliminar-permisos'
        ];

        foreach ($permissions as $perm) {
            try {
                Permission::create(['name' => $perm]);
            } catch (\Spatie\Permission\Exceptions\PermissionAlreadyExists $e) {
                //si el permiso ya existe, no hace nada y continua el ciclo
            }
        }

        $roles = [
            'SuperAdmin',
            'Dueño',
            'Administrador',
            'Gerencia',
            'Hospitales',
            'Medicos',
            'Pacientes'
        ];

        /*
         * */

        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);
            if ($roleName == 'SuperAdmin' || $roleName == 'Dueño' || $roleName == 'Adminstrador') {
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
        //dame todos los usuarios del 6 en Adelante
        $usuarios = User::query()->where('id', '>=', 6)->get();
        foreach ($usuarios as $usuario) {
            $Hospital = $usuario->hospital;
            //si hospital no tiene padre asigna el rol de Gerencia
            if ($Hospital->parent_id == null) {
                $usuario->assignRole('Gerencia');
            }
            //si hospital tiene padre asigna el rol de Hospitales solo si es el primer usuario con ese hospital_id
            if ($Hospital->parent_id != null) {
                $usuarios = User::query()->where('hospital_id', $Hospital->id)->get();
                if ($usuarios->count() == 1) {
                    $usuario->assignRole('Hospitales');
                }else{
                    $usuario->assignRole('Medicos');
                }
            }
            $usuario->assignRole('Medicos');
        }
    }
}
