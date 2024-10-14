<?php

namespace App\Services\Contrato;

use App\Interfaces\Contrato\ContratoInterface;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Collection;

class ContratoService
{
    public function __construct(private ContratoInterface $contratoRepository)
    {
    }

    public function getContracts(string $search, string $filter, string $orderColumn, string $orderDirection, int $paginate)
    {
        $query = $this->contratoRepository->query($orderColumn, $orderDirection)
            ->with([
                'paciente',
                'contratoUsuario.solicitante',
                'contratoUsuario.bajador',
                'contratoUsuario.solicitante.hospital',
                'contratoUsuario.bajador.hospital',
                'contratoUsuario.aprobador',
                'contratoUsuario.finalizador',
                'contratoFechas'
            ]);


        $query = match ($filter) {
            'solicitado' => $query->where('estado_orden', '0'),
            'aprobado' => $query->where('estado_orden', '1'),
            'rechazado' => $query->where('estado_orden', '2'),
            'anulado' => $query->where('estado_orden', '3'),
            'entregado' => $query->where('estado_orden', '4'),
            'recojo' => $query->where('estado_orden', '5'),
            'finalizado' => $query->where('estado_orden', '6'),
            default => $query,
        };

        // Búsqueda por el nombre del paciente, usuarios (solicitante, bajador, etc.) o el hospital
        if (!empty($search)) {
            $query->whereHas('paciente', function ($q) use ($search) {
                // Búsqueda por el nombre completo del paciente
                $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$search}%"]);
            })->orWhereHas('usuarios.solicitante', function ($q) use ($search) {
                // Búsqueda por el nombre del solicitante o el nombre/acrónimo del hospital del solicitante
                $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('hospital', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('acronimo', 'LIKE', "%{$search}%");
                    });
            })->orWhereHas('usuarios.bajador', function ($q) use ($search) {
                // Búsqueda por el nombre del bajador o el nombre/acrónimo del hospital del bajador
                $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('hospital', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('acronimo', 'LIKE', "%{$search}%");
                    });
            })->orWhereHas('usuarios.aprobador', function ($q) use ($search) {
                // Búsqueda por el nombre completo del aprobador
                $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$search}%"]);
            })->orWhereHas('usuarios.finalizador', function ($q) use ($search) {
                // Búsqueda por el nombre completo del finalizador
                $q->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$search}%"]);
            });
        }

        return $query->paginate($paginate);
    }

    public function guardarContrato($contrato)
    {
        // Guardar contrato
    }

    public function eliminarContrato($contrato)
    {
        // Eliminar contrato
    }

    public function obtenerContrato($contrato)
    {
        return $this->contratoRepository->getContratoById($contrato);
    }

    public function save(array $contrato): Contrato|Collection|null
    {
        return $this->contratoRepository->save(data: $contrato);

    }
}
