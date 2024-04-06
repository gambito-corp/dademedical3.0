<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;
use Illuminate\Support\Facades\DB; // Importa la clase DB para usar transacciones

class HospitalSeeder extends Seeder
{
    public function run()
    {
        // Utiliza transacciones para evitar errores de integridad de la base de datos
        DB::beginTransaction();

        try {
            // Crear Hospital Central de Pruebas De Codigo
            Hospital::factory()->create([
                'nombre' => 'Hospital Central de Pruebas De Codigo',
                'acronimo' => 'HCPC',
                'direccion' => 'Dirección inventada',
                'estado' => false,
            ]);

            // Crear Dademedical Peru Clientes Directos
            Hospital::factory()->create([
                'nombre' => 'Dademedical Peru Clientes Directos',
                'acronimo' => 'Dademedical',
                'direccion' => 'Dirección inventada',
                'estado' => true,
            ]);

            // Crear 3 IBT con estado Inactivo
            Hospital::factory()->count(3)->create([
                'acronimo' => 'IBT',
                'direccion' => 'Dirección inventada',
                'estado' => false,
            ]);

            // Crear 4 hospital Barton con estado Activo y padre IBT
            $ibt = Hospital::where('nombre', 'IBT')->first();
            if ($ibt) {
                Hospital::factory()->count(4)->create([
                    'acronimo' => 'Barton',
                    'estado' => true,
                    'parent_id' => $ibt->id,
                ]);
            }

            // Crear 5 hospital Kaelin con estado Activo y padre IBT
            if ($ibt) {
                Hospital::factory()->count(5)->create([
                    'acronimo' => 'Kaelin',
                    'estado' => true,
                    'parent_id' => $ibt->id,
                ]);
            }

            // Crear 10 hospitales adicionales con padres inventados
            Hospital::factory()->count(10)->create([
                'acronimo' => 'Hospital' . rand(100, 999),
                'direccion' => 'Dirección inventada',
                'estado' => rand(0, 1) ? true : false,
            ]);

            // Confirma las transacciones si no hay errores
            DB::commit();
        } catch (\Exception $e) {
            // Revierte las transacciones si ocurre algún error
            DB::rollBack();
            throw $e;
        }
    }
}
