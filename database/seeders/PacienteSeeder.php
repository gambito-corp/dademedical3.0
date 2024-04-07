<?php

namespace Database\Seeders;

use App\Models\Archivo;
use App\Models\Carrito;
use App\Models\Concentrador;
use App\Models\Contrato;
use App\Models\ContratoFechas;
use App\Models\ContratoUsuario;
use App\Models\Direccion;
use App\Models\Diagnostico;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\Regulador;
use App\Models\Tanque;
use App\Models\Telefono;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < rand(10, 100); $i++) {
            Paciente::factory()->create();
            for ($j = 0; $j <= 1; $j++) {
                $contrato = Contrato::factory()->create();

                Diagnostico::factory()->create([
                    'contrato_id' => $contrato->id,
                ]);

                ContratoFechas::factory()->create();
                ContratoUsuario::factory()->create();
                Direccion::factory()->create();
                for ($k = 0; $k <= rand(1,3); $k++) {
                    Telefono::factory()->create();
                }
                for ($l = 0; $l <= rand(1,3); $l++) {
                    Archivo::factory()->create();
                }

                // Para cada contrato, se asigna un concentrador
                $concentrador = Concentrador::factory()->create();
                $concentradorProducto = Producto::factory()->create([
                    'productable_type' => Concentrador::class,
                    'productable_id' => $concentrador->id,
                ]);
                DB::table('contrato_productos')->insert([
                    'contrato_id' => $contrato->id,
                    'producto_id' => $concentradorProducto->id,
                ]);

                // 75% de probabilidad de asignar un tanque
                if (rand(0, 100) < 75) {
                    $tanque = Tanque::factory()->create();
                    $tanqueProducto = Producto::factory()->create([
                        'productable_type' => Tanque::class,
                        'productable_id' => $tanque->id,
                    ]);
                    DB::table('contrato_productos')->insert([
                        'contrato_id' => $contrato->id,
                        'producto_id' => $tanqueProducto->id,
                    ]);

                    // Si se asignó un tanque, hay un 20% de probabilidad de asignar un regulador y un carrito
                    if (rand(0, 100) < 20) {
                        $regulador = Regulador::factory()->create();
                        $reguladorProducto = Producto::factory()->create([
                            'productable_type' => Regulador::class,
                            'productable_id' => $regulador->id,
                        ]);
                        DB::table('contrato_productos')->insert([
                            'contrato_id' => $contrato->id,
                            'producto_id' => $reguladorProducto->id,
                        ]);

                        $carrito = Carrito::factory()->create();
                        $carritoProducto = Producto::factory()->create([
                            'productable_type' => Carrito::class,
                            'productable_id' => $carrito->id,
                        ]);
                        DB::table('contrato_productos')->insert([
                            'contrato_id' => $contrato->id,
                            'producto_id' => $carritoProducto->id,
                        ]);
                    }
                }
            }
        }
    }
}
