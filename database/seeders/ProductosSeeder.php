<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Concentrador;
use App\Models\Tanque;
use App\Models\Regulador;
use App\Models\Carrito;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1,300) as $i) {
            $concentrador = Concentrador::factory()->create();
            Producto::factory()->create([
                'productable_type' => Concentrador::class,
                'productable_id' => $concentrador->id,
            ]);
        }

        foreach(range(1,300) as $i) {
            $tanque = Tanque::factory()->create();
            Producto::factory()->create([
                'productable_type' => Tanque::class,
                'productable_id' => $tanque->id,
            ]);
        }

        foreach(range(1,300) as $i) {
            $regulador = Regulador::factory()->create();
            Producto::factory()->create([
                'productable_type' => Regulador::class,
                'productable_id' => $regulador->id,
            ]);
        }

        foreach(range(1,300) as $i) {
            $carrito = Carrito::factory()->create();
            Producto::factory()->create([
                'productable_type' => Carrito::class,
                'productable_id' => $carrito->id,
            ]);
        }
    }
}
