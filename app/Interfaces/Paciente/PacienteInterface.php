<?php

namespace App\Interfaces\Paciente;

use App\Models\Paciente;
use Illuminate\Support\Collection;

interface PacienteInterface
{
    public function query($orderColumn = 'id', $orderDirection = 'desc');
    public function find($id): Paciente|Collection|null;
    public function findByDni($dni): Paciente|Collection|null;

    public function findWithTrashed($id): Paciente|Collection|null;
    public function all(): Collection;
    public function pacientesActivos() : Collection;
    public function pacientesInactivos() : Collection;
    public function pacientesPendientes() : Collection;
    public function allWithTrashed(): Collection;
    public function allOnlyTrashed(): Collection;
    public function save(array $data): Paciente|Collection|null;

    public function checkReniec($dni);

    public function update(array $data);
}
