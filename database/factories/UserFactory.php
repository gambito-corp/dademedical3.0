<?php

namespace Database\Factories;

use App\Models\Hospital;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    protected static ?string $password;


    protected $model = User::class;

    public function definition(): array
    {
        $hospitals = Hospital::query()->count();
        return [
            'hospital_id' => Hospital::query()->inRandomOrder()->first()->id, // Obtener un hospital aleatorio
            'name' => $this->faker->name,
            'surname' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function deleted(): static
    {
        return $this->state(function (array $attributes) {
            return ['deleted_at' => now()];
        });
    }
}
