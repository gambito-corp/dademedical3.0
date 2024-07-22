<?php
namespace App\Services\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use App\Services\Logs\LogService;
use Illuminate\Database\Eloquent\Collection;

class PacienteService
{
    public Collection $pacientes;

    public function __construct(protected PacienteInterface $pacienteRepository, protected LogService $logService){}

    public function getPatients(string $search, string $filter, string $orderColumn, string $orderDirection, int $paginate)
    {
        $query = $this->pacienteRepository->query($orderColumn, $orderDirection);

        $query = match ($filter) {
            'active' => $query->whereNull('pacientes.deleted_at'),
            'inactive' => $query->onlyTrashed(),
            default => $query,
        };

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('CONCAT(pacientes.name, " ", pacientes.surname) like ?', ["%{$search}%"])
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->whereHas('hospital', function($q) use ($search) {
                            $q->where('nombre', 'like', "%{$search}%");
                        });
                    });
            });
        }

        return $query->paginate($paginate);
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

    public function checkReniec($dni)
    {
        return $this->pacienteRepository->checkReniec($dni);




        return [
            'numero_documento' => '12345678',
            'nombres' => 'Pedro',
            'apellidos' => 'Aguirre'
        ];
    }
}
