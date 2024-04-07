<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\Direccion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class DireccionFactory extends Factory
{
    protected $model = Direccion::class;

    public function definition(): array
    {
        $faker = Faker::create();

        return [
            'contrato_id' => Contrato::all()->last()->id,
            'distrito' => $faker->city,
            'calle' => $faker->streetName,
            'referencia' => ($faker->randomElement([true, false])) ? $faker->sentence : null,
            'responsable' => ($faker->randomElement([true, false])) ? $faker->name : null,
            'fecha_cambio' => ($faker->randomElement([true, false])) ? $faker->dateTime : null,
            'active' => $faker->boolean,
        ];
    }
}
