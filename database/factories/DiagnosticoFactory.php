<?php

namespace Database\Factories;

use App\Models\Diagnostico;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiagnosticoFactory extends Factory
{
    protected $model = Diagnostico::class;

    public function definition(): array
    {
        return [
            'contrato_id' => Contrato::factory(),
            'historia_clinica' => $this->faker->text(200),
            'diagnostico'=> $this->faker->sentence(),
            'dosis' => $this->faker->randomFloat(2, 0, 100),
            'frecuencia' => $this->faker->numberBetween(1, 24),
            'comentarios' =>$this->faker->text(200),
            'active' => $this->faker->randomElement(['active', 'inactive']),
            'fecha_cambio' => $this->faker->date('Y-m-d H:i:s'),
        ];
    }
}
