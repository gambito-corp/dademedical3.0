<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'codigo' => $this->faker->unique()->numerify('Codigo ####'),
            'contrato_id' => null, //Estara llenado por la ejecucion de alguna seeder que maneje la relacion directamente.
            'activo' => $this->faker->boolean,
            'fecha_mantenimiento' => $this->faker->date(),
            'productable_type' => null, //Estara llenado por la ejecucion de alguna seeder que maneje la relacion directamente.
            'productable_id' => null, //Estara llenado por la ejecucion de alguna seeder que maneje la relacion directamente.
        ];
    }
}
