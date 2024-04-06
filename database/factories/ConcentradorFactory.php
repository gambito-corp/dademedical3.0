<?php

namespace Database\Factories;

use App\Models\Concentrador;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConcentradorFactory extends Factory
{
    protected $model = Concentrador::class;

    public function definition()
    {
        return [
            'capacidad' => $this->faker->randomNumber(),
            'marca' => $this->faker->company,
            'modelo' => $this->faker->word,
        ];
    }
}
