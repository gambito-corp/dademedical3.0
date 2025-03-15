<?php

namespace App\Services\Inventario;

use App\Repositories\Inventario\InventarioRepository;
use App\Services\Logs\LogService;

class InventarioService
{

    public function __construct(
        protected InventarioRepository $inventarioRepository,
        protected LogService $logService,
    ){}

    public function getInventario(string $search, string $filter, string $subFilter, string $orderColumn, mixed $ordenDirection, int $paginate)
    {
        $query = $this->inventarioRepository->query($orderColumn, $ordenDirection);
        $query = match ($filter) {
            'Maquinas' => $this->filterMaquinas($query->where('productable_type', 'App\Models\Concentrador'), $subFilter),
            'Tanques' => $this->filterTanques($query->where('productable_type', 'App\Models\Tanque'), $subFilter),
            'Reguladores' => $this->filterReguladores($query->where('productable_type', 'App\Models\Regulador'), $subFilter),
            'Carritos' => $this->filterCarritos($query->where('productable_type', 'App\Models\Carrito'), $subFilter),
            default => $query,
        };
        if($search){
            $query = $query->where('codigo', 'like', "%{$search}%")
                ->when($filter === 'Maquinas', function($q) use ($search) {
                    return $q->orWhereHas('productable', function($q) use ($search) {
                        $q->where('marca', 'like', "%{$search}%")
                            ->orWhere('modelo', 'like', "%{$search}%")
                            ->orWhere('capacidad', 'like', "%{$search}%");
                    });
                })
                ->orWhereHas('contrato', function($q) use ($search) {
                    $q->whereHas('paciente', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('surname', 'like', "%{$search}%");
                    });
                });
        }
        return $query->paginate($paginate);
    }

    private function filterMaquinas($query, $subFilter)
    {
        return match ($subFilter) {
            'activos' => $query->where('activo', true),
            'alquilados' => $query->where('activo', false)->whereNotNull('contrato_id'),
            'mantenimiento' => $query->where('activo', false)->whereNull('contrato_id')->where('fecha_mantenimiento', '>', now()),
            'baja' => $query->where('activo', false)->whereNull('contrato_id'),
            'registro' => $query,
            default => $query,
        };
    }

    private function filterTanques($query, $subFilter)
    {
        return match ($subFilter) {
            'activos' => $query->where('activo', true),
            'alquilados' => $query->where('activo', false)->whereNotNull('contrato_id'),
            'baja' => $query->where('activo', false)->whereNull('contrato_id'),
            default => $query,
        };
    }

    private function filterReguladores($query, $subFilter)
    {
        return match ($subFilter) {
            'activos' => $query->where('activo', true),
            'alquilados' => $query->where('activo', false)->whereNotNull('contrato_id'),
            'baja' => $query->where('activo', false)->whereNull('contrato_id'),
            default => $query,
        };
    }

    private function filterCarritos($query, $subFilter)
    {
        return match ($subFilter) {
            'activos' => $query->where('activo', true),
            'alquilados' => $query->where('activo', false)->whereNotNull('contrato_id'),
            'baja' => $query->where('activo', false)->whereNull('contrato_id'),
            default => $query,
        };
    }


//    public function getPatients(string $search, string $filter, string $orderColumn, string $orderDirection, int $paginate)
//    {
//        $query = $this->pacienteRepository->query($orderColumn, $orderDirection);
//
//        $query = match ($filter) {
//            'active' => $query->where('active', '1')->whereNull('pacientes.deleted_at'),
//            'inactive' => $query->where('active', '0')->withTrashed(),
//            default => $query,
//        };
//
//        if ($search) {
//            $query->where(function($q) use ($search) {
//                $q->whereRaw('CONCAT(pacientes.name, " ", pacientes.surname) like ?', ["%{$search}%"])
//                    ->orWhere('dni', 'like', "%{$search}%")
//                    ->orWhereHas('user', function($q) use ($search) {
//                        $q->whereHas('hospital', function($q) use ($search) {
//                            $q->where('nombre', 'like', "%{$search}%");
//                        });
//                    })->orWhereRaw("(CASE
//                        WHEN origen = 1 THEN 'Consulta Externa'
//                        WHEN origen = 2 THEN 'UDO'
//                        ELSE ''
//                    END) LIKE ?", ["%{$search}%"])
//                    ->orWhereHas('contrato', function ($q) use ($search) {
//                        $q->whereHas('contratoFechas', function ($q) use ($search) {
//                            $q->where('fecha_solicitud', 'like', "%{$search}%")
//                                /* ->orWhere('fecha_entrega', 'like', "%{$search}%")
//                                 ->orWhere('fecha_finalizado', 'like', "%{$search}%")*/;
//                        });
//                    });
//            });
//            // agregarn filtro por Fechas de Ingreso y entrega / egreso
////            dd($query->get());
//        }
//        // Agregar las relaciones necesarias usando with()
//        $query->with(['contrato.diagnosticosPendientes']);
//
//        return $query->paginate($paginate);
//    }

    public function findWithTrashed(mixed $inventarioId)
    {
    }
}
