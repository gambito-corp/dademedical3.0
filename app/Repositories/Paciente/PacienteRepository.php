<?php

namespace App\Repositories\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use App\Models\Paciente;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PacienteRepository implements PacienteInterface
{

    protected $pacientes;

    public function __construct(Paciente $pacientes)
    {
        $this->pacientes = $pacientes;
    }


    public function all()
    {
        return $this->pacientes->all();
    }

    public function pacientesActivos()
    {
        return $this->pacientes->with([
            'contratos' => function ($query) {
                $query->latest();
            }
        ])->whereHas('contratos', function ($query) {
            $latestContractSubQuery = DB::table('contratos')
                ->select('paciente_id', DB::raw('MAX(id) as id'))
                ->groupBy('paciente_id');

            $query->joinSub($latestContractSubQuery, 'latest_contract', function ($join) {
                $join->on('contratos.id', '=', 'latest_contract.id');
            })->whereIn('contratos.estado_orden', [4, 5]);
        })->get();
    }

    public function pacientesInactivos()
    {
        return $this->pacientes->with([
                'contrato' => function ($query) {
                    $query->latest();
                }
            ])->whereHas('contrato', function ($query) {
                $latestContractSubQuery = DB::table('contratos')
                    ->select('paciente_id', DB::raw('MAX(id) as id'))
                    ->groupBy('paciente_id');

                $query->joinSub($latestContractSubQuery, 'latest_contract', function ($join) {
                    $join->on('contratos.id', '=', 'latest_contract.id');
                })->whereIn('contratos.estado_orden', [6]);
            })->get();
    }
    public function pacientesPendientes()
    {
        return $this->pacientes->with([
                'contrato' => function ($query) {
                    $query->latest();
                }
            ])->whereHas('contrato', function ($query) {
                $latestContractSubQuery = DB::table('contratos')
                    ->select('paciente_id', DB::raw('MAX(id) as id'))
                    ->groupBy('paciente_id');

                $query->joinSub($latestContractSubQuery, 'latest_contract', function ($join) {
                    $join->on('contratos.id', '=', 'latest_contract.id');
                })->whereIn('contratos.estado_orden', [0,1]);
            })->get();
    }

    public function create(array $data): Paciente|Collection|null
    {

    }

//    public function allOnlyTrashed(): Collection
//    {
//        // TODO: Implement allOnlyTrashed() method.
//    }
//
//
//    public function update(Paciente $paciente, array $data): Paciente|Collection|null
//    {
//        // TODO: Implement update() method.
//    }
//
//    public function find($id): Paciente|Collection|null
//    {
//        // TODO: Implement find() method.
//    }
}
