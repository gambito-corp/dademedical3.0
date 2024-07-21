<?php
namespace App\Repositories\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use App\Models\Paciente;
use Illuminate\Support\Collection;

class PacienteRepository implements PacienteInterface
{
    public function __construct(protected Paciente $pacientes){}

    public function query($orderColumn = 'id', $orderDirection = 'desc')
    {
        $query = $this->pacientes->newQuery();

        if ($orderColumn === 'hospital_nombre') {
            $query->leftJoin('users as u', 'u.id', '=', 'pacientes.user_id')
                ->leftJoin('hospitals as h', 'h.id', '=', 'u.hospital_id')
                ->orderBy('h.nombre', $orderDirection)
                ->select('pacientes.*');
        } else {
            $query->orderBy($orderColumn, $orderDirection);
        }

        return $query;
    }

    public function find($id): Paciente|Collection|null
    {
        return $this->pacientes->find($id);
    }

    public function findWithTrashed($id): Paciente|Collection|null
    {
        return $this->pacientes->withTrashed()->find($id);
    }

    public function all(): Collection
    {
        return $this->pacientes->all();
    }

    public function pacientesActivos(): Collection
    {
        return $this->pacientes->with(['contratos' => function ($query) {
            $query->latest();
        }])->whereHas('contratos', function ($query) {
            $query->whereIn('estado_orden', [4, 5]);
        })->get();
    }

    public function pacientesInactivos(): Collection
    {
        return $this->pacientes->with(['contrato' => function ($query) {
            $query->latest();
        }])->whereHas('contrato', function ($query) {
            $query->whereIn('estado_orden', [6]);
        })->get();
    }

    public function pacientesPendientes(): Collection
    {
        return $this->pacientes->with(['contrato' => function ($query) {
            $query->latest();
        }])->whereHas('contrato', function ($query) {
            $query->whereIn('estado_orden', [0, 1]);
        })->get();
    }

    public function allWithTrashed(): Collection
    {
        return $this->pacientes->withTrashed()->get();
    }

    public function allOnlyTrashed(): Collection
    {
        return $this->pacientes->onlyTrashed()->get();
    }

    public function create(array $data): Paciente|Collection|null
    {
        return $this->pacientes->create($data);
    }
}
