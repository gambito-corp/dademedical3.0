<?php
namespace App\Services\Paciente;

use App\Interfaces\Paciente\PacienteInterface;
use App\Models\Contrato;
use App\Models\Paciente;
use App\Services\Archivo\ArchivoService;
use App\Services\Contrato\ContratoService;
use App\Services\Diagnostico\DiagnosticoService;
use App\Services\Direccion\DireccionService;
use App\Services\Logs\LogService;
use App\Services\Telefono\TelefonoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PacienteService
{
    public Collection $pacientes;

    public function __construct(
        protected PacienteInterface $pacienteRepository,
        protected LogService $logService,
        protected DireccionService $direccionService,
        protected TelefonoService $telefonoService,
        protected DiagnosticoService $diagnosticoService,
        protected ContratoService $contratoService,
        protected ArchivoService $archivoService
    ){}

    public function getPatients(string $search, string $filter, string $orderColumn, string $orderDirection, int $paginate)
    {
        $query = $this->pacienteRepository->query($orderColumn, $orderDirection);

        $query = match ($filter) {
            'active' => $query->where('active', '1')->whereNull('pacientes.deleted_at'),
            'inactive' => $query->where('active', '0')->withTrashed(),
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
                    })->orWhereRaw("(CASE
                        WHEN origen = 1 THEN 'Consulta Externa'
                        WHEN origen = 2 THEN 'UDO'
                        ELSE ''
                    END) LIKE ?", ["%{$search}%"]);
            });
        }
        // Agregar las relaciones necesarias usando with()
        $query->with(['contrato.diagnosticosPendientes']);

        return $query->paginate($paginate);
    }
    public function findWithTrashed($id)
    {
        return $this->pacienteRepository->findWithTrashed($id);
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

    public function create(array $data): Paciente|Collection|null
    {
        DB::beginTransaction();
        $paciente = $this->save($data);
        $data['paciente_id'] = $paciente->id;
        $contrato = $this->redirigirServiceContrato($data);
        $data['contrato_id'] = $contrato->id;
        $this->redirigirServiceDireccion($data);
        $this->redirigirServiceTelefonos($data);
        $this->redirigirServiceDiagnostico($data);
        $this->redirigirServiceArchivos($data);
        DB::commit();
        return $this->pacienteRepository->find($data['paciente_id']);
    }
    public function edit(array $data)
    {
        $paciente = $this->update($data);
        if ($paciente) {
            $this->redirigirServiceDireccionUpdate($data);
            $this->redirigirServiceTelefonosUpdate($data);
            $this->redirigirServiceArchivosUpdate($data);
        }
    }
    public function checkReniec($dni)
    {
        return $this->pacienteRepository->checkReniec($dni);
    }

    private function redirigirServiceDireccion(array $data)
    {
        $infoDireccion = [
            'contrato_id' => $data['contrato_id'],
            'distrito' => $data['distrito'],
            'calle' => Str::title($data['direccion']),
            'referencia' => Str::title($data['referencia']),
            'responsable' => Str::title($data['familiar_responsable']),
            'active' => 1,
        ];

        return $this->direccionService->save(direccion: $infoDireccion);
    }

    private function redirigirServiceTelefonos(array $data)
    {
        $this->telefonoService->save(telefonos: $data['telefonos'], contractId: $data['contrato_id']);
    }

    private function redirigirServiceDiagnostico(array $data)
    {
        $infoDiagnostico = [
            'contrato_id' => $data['contrato_id'],
            'historia_clinica' => $data['historia_clinica'],
            'diagnostico' => Str::title($data['diagnostico']),
            'dosis' => $data['dosis'],
            'frecuencia' => $data['horas_oxigeno'],
            'active' => true,
        ];

        $this->diagnosticoService->save(diagnostico: $infoDiagnostico);
    }

    private function redirigirServiceContrato(array $data): Contrato|Collection|null
    {
        $infoContrato = [
            'paciente_id' => $data['paciente_id'],
            'estado_orden' => 0,
            'traqueotomia' => $data['traqueotomia'],
        ];

        return $this->contratoService->save(contrato: $infoContrato);
    }

    private function redirigirServiceArchivos(array $data)
    {
        $infoArchivos = [
            'solicitud_oxigenoterapia' => $data['solicitud_oxigenoterapia'] ?? null,
            'declaracion_jurada' => $data['declaracion_jurada'] ?? null,
            'documento_identidad' => $data['documento_identidad'] ?? null,
            'documento_identidad_cuidador' => $data['documento_identidad_cuidador'] ?? null,
            'croquis' => $data['croquis'] ?? null,
            'otros' => $data['otros'] ?? null,
        ];
        $this->archivoService->save(archivos: $infoArchivos, contractId: $data['contrato_id'], patientId: $data['paciente_id'], name: $data['nombres'], surname: $data['apellidos']);
    }

    private function save(array $data): Paciente|Collection|null
    {
        $infoPaciente = [
            'user_id' => auth()->id(),
            'dni' => $data['numero_documento'],
            'name' => Str::title($data['nombres']),
            'surname' => Str::title($data['apellidos']),
            'edad' => $data['edad'],
            'origen' => $data['tipo_origen'],
            'primer_ingreso' => !$data['reingreso'],
            'active' => 1,
        ];
        return $this->pacienteRepository->save(data: $infoPaciente);
    }

    private function update(array $data)
    {
        return $this->pacienteRepository->update($data);
    }

    private function redirigirServiceDireccionUpdate(array $data)
    {
        $infoDireccion = [
            'patientId' => $data['patientId'],
            'responsable' => Str::title($data['familiar_responsable']),
        ];

        return $this->direccionService->update(direccion: $infoDireccion);
    }

    private function redirigirServiceTelefonosUpdate(array $data)
    {
        $this->telefonoService->update(telefonos: $data['telefonos'], patientId: $data['patientId']);
    }

    private function redirigirServiceArchivosUpdate(array $data)
    {
        $paciente = Paciente::query()->with('contrato')->findOrFail($data['patientId']);
        $infoArchivos = [
            'otros' => $data['otros'] ?? null,
        ];
        $this->archivoService->save(archivos: $infoArchivos, contractId: $paciente->contrato->id, patientId: $paciente->id, name: $data['nombres'], surname: $data['apellidos']);
    }
}
