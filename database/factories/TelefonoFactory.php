<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;

class TelefonoFactory extends Factory
{
    protected $model = Telefono::class;

    public function definition(): array
    {
        return [
            'contrato_id' => Contrato::all()->last()->id,
            'numero' => $this->faker->unique()->phoneNumber,
            'tipo' => $this->faker->randomElement(['móvil', 'casa', 'trabajo']),
        ];
    }
}
