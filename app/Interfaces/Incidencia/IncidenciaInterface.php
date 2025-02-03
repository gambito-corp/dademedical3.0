<?php

namespace App\Interfaces\Incidencia;

interface IncidenciaInterface
{
    public function query($orderColumn, $orderDirection);

    public function getActiveIncidences($query);

    public function getInactiveIncidences($query);

    public function search($query, $search);

    public function findWithTrashed($id);

    public function update(array $data);
}
