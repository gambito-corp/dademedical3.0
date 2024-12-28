<?php

namespace App\Livewire\Incidences;

use App\Livewire\BaseComponent;
use App\Models\Incidencia;

class Incidence extends BaseComponent
{
    public function changeIncidence($state)
    {
        $this->currentFilter = $state;
    }
    public function render()
    {
        if ($this->currentFilter == 'active') {
            // 1. Obtenemos la consulta base de incidencias activas, con filtros
            $query = $this->getActiveIncidences();

            // 2. Aplicamos ordenamiento
            $query = $this->applyOrdering($query);

            // 3. Finalmente obtenemos los resultados
            $data = $query->get();
        } else {
            // Incidencias con responding_user_id (no activas)
            $data = Incidencia::whereNotNull('responding_user_id')
                ->with('contrato.paciente', 'user.hospital')
                ->get();
        }
        return view('livewire.incidences.incidence', compact('data'));
    }

    protected function getActiveIncidences()
    {
        return Incidencia::query()
            ->with('contrato.paciente', 'user.hospital')
            ->whereNull('responding_user_id')
            ->where(function($q) {
                $q->whereHas('contrato', function($subQ) {
                    $subQ->whereHas('paciente', function($subSubQ) {
                        // Filtro por paciente (name + surname)
                        $subSubQ->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$this->search}%"]);
                    });
                })
                    ->orWhereHas('user', function($subQ) {
                        // Filtro por usuario (name + surname)
                        $subQ->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$this->search}%"])
                            ->orWhereHas('hospital', function($subSubQ) {
                                // Filtro por hospital (nombre)
                                $subSubQ->where('nombre', 'LIKE', "%{$this->search}%");
                            });
                    });
            })
            // Filtro por campos en la tabla incidencias
            ->orWhere('incidencia', 'LIKE', "%{$this->search}%")
            ->orWhere('tipo_incidencia', 'LIKE', "%{$this->search}%")
            ->orWhere('fecha_incidencia', 'LIKE', "%{$this->search}%")
            ->orWhere('fecha_respuesta', 'LIKE', "%{$this->search}%");
    }

    protected function applyOrdering($query)
    {
        switch ($this->orderColumn) {
            case 'paciente.nombre':
                // Necesitamos unir 'contratos' y 'pacientes'
                $query->join('contratos', 'incidencias.contrato_id', '=', 'contratos.id')
                    ->join('pacientes', 'contratos.paciente_id', '=', 'pacientes.id')
                    ->select('incidencias.*')
                    ->orderBy('pacientes.name', $this->orderDirection);
                break;

            case 'usuario.nombre':
                // Necesitamos unir la tabla 'users'
                $query->join('users', 'incidencias.user_id', '=', 'users.id')
                    ->select('incidencias.*')
                    ->orderBy('users.name', $this->orderDirection);
                break;

            case 'usuario.hospitales':
                // Unimos 'users' y 'hospitals'
                $query->join('users', 'incidencias.user_id', '=', 'users.id')
                    ->join('hospitals', 'users.hospital_id', '=', 'hospitals.id')
                    ->select('incidencias.*')
                    ->orderBy('hospitals.nombre', $this->orderDirection);
                break;

            case 'tipo_incidencia':
                $query->orderBy('tipo_incidencia', $this->orderDirection);
                break;

            case 'comentario':
                $query->orderBy('incidencia', $this->orderDirection);
                break;

            case 'fecha_incidencia':
                $query->orderBy('fecha_incidencia', $this->orderDirection);
                break;

            case 'fecha_respuesta':
                $query->orderBy('fecha_respuesta', $this->orderDirection);
                break;

            default:
                // Si no coincide con ningún caso, podrías dejarlo sin orden o manejar un orden por defecto
                break;
        }

        return $query;
    }
}
