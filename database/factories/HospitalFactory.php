<?php

namespace Database\Factories;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalFactory extends Factory
{

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'acronimo' => $this->faker->word,
            'direccion' => $this->faker->address,
            'parent_id' => null,
            'estado' => true,
        ];
    }

    public function parent(): self
    {
        //crea una Relacion con el modelo Hospital para el campo parent_id solo si lo especifico
        return $this->state(fn() => [
            'parent_id' => Hospital::factory(),
        ]);
    }
}
