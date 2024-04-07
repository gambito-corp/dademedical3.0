<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(HospitalSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(PacienteSeeder::class);

    }
}
