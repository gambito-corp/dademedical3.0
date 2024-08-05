<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar el almacenamiento S3 antes de sembrar datos
        Artisan::call('storage:clear-s3');

        $this->call(HospitalSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(PacienteSeeder::class);

    }
}
