<?php

namespace Database\Factories;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PacienteFactory extends Factory
{

    protected $model = Paciente::class;

    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id, // Obtener un Hospital aleatorio
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'dni' => $this->faker->unique()->randomNumber(8),
            'edad' => $this->faker->numberBetween(1, 100),
            'primer_ingreso' => $this->faker->boolean,
            'origen' => $this->faker->randomElement([1,2,3]),
            'active' => $this->faker->boolean,
        ];
    }
}
