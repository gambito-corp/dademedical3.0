<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Contrato;
use App\Models\ContratoUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratoUsuarioFactory extends Factory
{
    protected $model = ContratoUsuario::class;

    public function definition(): array
    {
        $contrato = Contrato::all()->last();
        if($contrato->estado_orden >= 5){
            return [
                'contrato_id' => $contrato->id,
                'solicitante_id' => $contrato->paciente->user->id,
                'aprobador_id' => 2,
                'bajador_id' =>  $contrato->paciente->user->id,
                'finalizador_id' => 2,
            ];
        }else{
            return [
                'contrato_id' => $contrato->id,
                'solicitante_id' => $contrato->paciente->id,
                'aprobador_id' => 2,
                'bajador_id' =>  null,
                'finalizador_id' => null,
            ];

        }
    }
}
