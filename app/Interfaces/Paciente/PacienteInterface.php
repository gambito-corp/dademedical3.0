<?php

namespace App\Interfaces\Paciente;

use App\Models\Paciente;
use Illuminate\Support\Collection;

interface PacienteInterface
{
    public function all();
    public function pacientesActivos();
    public function pacientesInactivos();
    public function pacientesPendientes();
    public function create(array $data): Paciente|Collection|null;
//    public function allOnlyTrashed(): Collection;
//    public function update(Paciente $paciente, array $data): Paciente|Collection|null;
//    public function find($id): Paciente|Collection|null;
}
