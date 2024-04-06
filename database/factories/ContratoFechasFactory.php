<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\ContratoFechas;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratoFechasFactory extends Factory
{
    protected $model = ContratoFechas::class;

   public function definition(): array
    {
        $contrato = Contrato::all()->last();
        $estadoOrden = $contrato->estado_orden;

        $fechaSolicitud = $this->faker->dateTimeBetween('-1 year');

        switch ($estadoOrden) {
            case 0:
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                ];
            case 1:
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_aprobacion' => $this->faker->dateTimeBetween($fechaSolicitud),
                ];
            case 2:
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_rechazo' => $this->faker->dateTimeBetween($fechaSolicitud),
                ];
            case 3:
                $fechaAprobacion = $this->faker->dateTimeBetween($fechaSolicitud);
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_aprobacion' => $fechaAprobacion,
                    'fecha_anulacion' => $this->faker->dateTimeBetween($fechaAprobacion),
                ];
            case 4:
                $fechaAprobacion = $this->faker->dateTimeBetween($fechaSolicitud);
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_aprobacion' => $fechaAprobacion,
                    'fecha_entrega' => $this->faker->dateTimeBetween($fechaAprobacion),
                ];
            case 5:
                $fechaAprobacion = $this->faker->dateTimeBetween($fechaSolicitud);
                $fechaEntrega = $this->faker->dateTimeBetween($fechaAprobacion);
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_aprobacion' => $fechaAprobacion,
                    'fecha_entrega' => $fechaEntrega,
                    'fecha_baja' => $this->faker->dateTimeBetween($fechaEntrega),
                    'fecha_recogida' => $this->faker->dateTimeBetween($fechaEntrega),
                ];
            case 6:
                $fechaAprobacion = $this->faker->dateTimeBetween($fechaSolicitud);
                $fechaEntrega = $this->faker->dateTimeBetween($fechaAprobacion);
                $fechaBaja = $this->faker->dateTimeBetween($fechaEntrega);
                return [
                    'contrato_id' => $contrato->id,
                    'fecha_solicitud' => $fechaSolicitud,
                    'fecha_aprobacion' => $fechaAprobacion,
                    'fecha_entrega' => $fechaEntrega,
                    'fecha_baja' => $fechaBaja,
                    'fecha_recogida' => $this->faker->dateTimeBetween($fechaBaja),
                    'fecha_finalizado' => $this->faker->dateTimeBetween($fechaBaja),
                ];
            default:
                return [];
        }
    }
}
