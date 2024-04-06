<?php

namespace Database\Factories;

use App\Models\Tanque;
use Illuminate\Database\Eloquent\Factories\Factory;

class TanqueFactory extends Factory
{
    protected $model = Tanque::class;

    public function definition()
    {
        return [
            'capacidad' => $this->faker->randomNumber(),
        ];
    }
}
