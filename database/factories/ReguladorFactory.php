<?php

namespace Database\Factories;

use App\Models\Regulador;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReguladorFactory extends Factory
{
    protected $model = Regulador::class;

    public function definition()
    {
        return [
            'capacidad' => $this->faker->randomNumber(),
        ];
    }
}
