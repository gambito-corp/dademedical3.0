<?php /** @noinspection ALL */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usersData = [
            [
                'hospital_id'        => 1,
                'name'              => 'Sidi Farid',
                'surname'           => 'Raoui Aguirre',
                'password'          => bcrypt('C4tntnox*+'),
                'username'          => 'Gambito',
                'email'             => 'asesor.pedro@gmail.com',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
            [
                'hospital_id'        => 2,
                'name'              => 'dademedical',
                'surname'           => 'Administracion',
                'password'          => bcrypt('a192310a'),
                'username'          => 'dademedical',
                'email'             => 'asistente@dademedicalperu.com',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
            [
                'hospital_id'        => 4,
                'name'              => 'barton',
                'surname'           => 'Administracion',
                'password'          => bcrypt('pruebabarton'),
                'username'          => 'hospitalbarton',
                'email'             => 'andrea.tantalean@callaosalud.com.pe2',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
            [
                'hospital_id'        => 5,
                'name'              => 'kaelin',
                'surname'           => 'Administracion',
                'password'          => bcrypt('pruebakaelin'),
                'username'          => 'hospitalkaelin',
                'email'             => 'carla.jaramillo@vmtsalud.com.pe2',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
            [
                'hospital_id'        => 4,
                'name'              => 'Andrea',
                'surname'           => 'Tantalean Colan',
                'password'          => bcrypt('70064692'),
                'username'          => '70064692',
                'email'             => 'andrea.tantalean@callaosalud.com.pe',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
            [
                'hospital_id'        => 5,
                'name'              => 'Carla',
                'surname'           => 'Jaramillo Garibay',
                'password'          => bcrypt('41988688'),
                'username'          => '41988688',
                'email'             => 'carla.jaramillo@vmtsalud.com.pe',
                'activo'            => 1,
                'email_verified_at' => now(),
            ],
        ];
        foreach ($usersData as $userData) {
            User::create($userData);
        }
        // Crear 15 usuarios con correo electrónico no verificado
        User::factory()->unverified()->count(10)->create();

        // Crear 20 usuarios eliminados
        User::factory()->deleted()->count(10)->create();

        // Completar la creación de los 65 usuarios restantes con valores predeterminados
        User::factory()->count(10)->create();


    }
}
