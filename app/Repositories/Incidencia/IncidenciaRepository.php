<?php

namespace App\Repositories\Incidencia;

use App\Interfaces\Incidencia\IncidenciaInterface;
use App\Models\Incidencia;

class IncidenciaRepository implements IncidenciaInterface
{
    public function __construct(protected Incidencia $incidencia)
    {
    }
    public function query($orderColumn, $orderDirection)
    {
        $query = $this->incidencia->newQuery();

        $query->orderBy($orderColumn, $orderDirection);

        return $query;
    }

    public function getActiveIncidences($query)
    {
        return $query->where('active', '1')->whereNull('incidencias.deleted_at');
    }

    public function getInactiveIncidences($query)
    {
        return $query->where('active', '0')->withTrashed();
    }

    public function search($query, $search)
    {
        return $query->where('incidencia', 'like', "%$search%")
            ->orWhere('respuesta', 'like', "%$search%");
    }

    public function findWithTrashed($id)
    {
        return $this->incidencia->withTrashed()->find($id);
    }

    public function update(array $data)
    {
        $incidence = $this->incidencia->findOrFail($data['id']);
        try {
            $incidence->update($data);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return $incidence->update($data);
    }

}
