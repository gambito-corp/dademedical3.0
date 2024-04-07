<?php

namespace Database\Factories;

use App\Models\Archivo;
use App\Models\ContratoFechas;
use App\Models\ContratoUsuario;
use App\Models\Direccion;
use App\Models\Paciente;
use App\Models\Telefono;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contrato;

class ContratoFactory extends Factory
{
    protected $model = Contrato::class;

    public function definition()
    {
        return [
            'paciente_id' => Paciente::all()->last()->id,
            'estado_orden' => $this->faker->randomElement(array_keys(array_filter(Contrato::ESTADO_ORDEN, function($key) {
                return $key != 6;
            }, ARRAY_FILTER_USE_KEY))),
            'traqueotomia' => $this->faker->boolean,
            'motivo_alta' => null,
            'comentario_alta' => null,
        ];
    }

    public function altaMedica()
    {
        return [
            'paciente_id' => Paciente::all()->last()->id,
            'estado_orden' => 6,
            'traqueotomia' => $this->faker->boolean,
            'motivo_alta' => $this->faker->sentence(6, true),
            'comentario_alta' => $this->faker->sentence(6, true),
        ];
    }
}
