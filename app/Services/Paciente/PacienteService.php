<?php

namespace App\Services\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use Illuminate\Database\Eloquent\Collection;

class PacienteService
{
    public Collection $pacientes;
    protected $pacienteRepository;

    public function __construct(PacienteInterface $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function all()
    {
        return $this->pacienteRepository->all();
    }

    public function pacientesActivos()
    {
        return $this->pacienteRepository->pacientesActivos();
    }

    public function pacientesInactivos()
    {
        return $this->pacienteRepository->pacientesInactivos();
    }

    public function pacientesPendientes()
    {
        return $this->pacienteRepository->pacientesPendientes();
    }
    public function create(array $data): Collection
    {
        return $this->pacienteRepository->create($data);
    }
    public function checkReniec()
    {
        return 'Toca Pelotas';
    }

}
