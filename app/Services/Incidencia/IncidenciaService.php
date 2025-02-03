<?php

namespace App\Services\Incidencia;

use App\Interfaces\Incidencia\IncidenciaInterface;

class IncidenciaService
{

    public function __construct(protected IncidenciaInterface $incidenciaRepository)
    {
    }

    public function getIncidences($search, $filter, $orderColumn, $orderDirection, $paginate)
    {
        $query = $this->incidenciaRepository->query($orderColumn, $orderDirection);

        $query = match ($filter) {
            'active' => $this->incidenciaRepository->getActiveIncidences($query),
            'inactive' => $this->incidenciaRepository->getInactiveIncidences($query),
            default => $query,
        };

        if($search){
            $query = $this->incidenciaRepository->search($query, $search);
        }

        return $query->with('contrato.paciente',
            'user',
            'respondingUser'
        )->paginate($paginate);
    }

    public function findWithTrashed($id)
    {
        return $this->incidenciaRepository->findWithTrashed($id);
    }

    public function update($incidence)
    {
        try {
            $this->incidenciaRepository->update($incidence);

        }catch (\Exception $e){
            dd('eN EL sERVICIO', $e->getMessage());
        }
    }
}
