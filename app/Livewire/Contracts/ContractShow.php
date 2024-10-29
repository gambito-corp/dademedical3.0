<?php

namespace App\Livewire\Contracts;

use App\Models\Contrato;
use App\Services\Archivo\ArchivoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\On;

class ContractShow extends Component
{
    public Contrato $contract;
    protected ArchivoService $archivoService;

    public bool $showDocument = false;
    public string $document = '';
    public string $urlImagen = '';
    #[On('orden-actualizada')]
    public function OrdenActualizada($contractId)
    {
        $this->contract = Contrato::query()->find($contractId['contractId']);
    }

    public function boot(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }

    public function mount(Contrato $contract)
    {
        $this->contract = $contract;

        // Cargar relaciones necesarias
        $this->contract->load([
            'paciente',
            'archivos',
            'direccion',
            'telefonos',
            'contratoUsuario.solicitante',
            'contratoUsuario.aprobador',
            'contratoUsuario.bajador',
            'contratoUsuario.finalizador',
            'contratoFechas',
        ]);
    }

    public function render()
    {
        return view('livewire.contracts.contract-show', [
            'contract' => $this->contract,
        ]);
    }

    public function openModal(string $filename)
    {
        $this->document = $filename;
        $this->showDocument = true;

        // Obtener la URL de la imagen
        $this->urlImagen = $this->obtenerUrlImagen($filename);
    }

    public function closeModal()
    {
        $this->showDocument = false;
        $this->document = '';
        $this->urlImagen = '';
    }

    private function obtenerUrlImagen(string $rutaArchivo): ?string
    {
        $disk = Storage::disk('s3');
        $ruta = 'Documentos/Archivos/' . $rutaArchivo;

        if ($disk->exists($ruta)) {
            $url = $disk->temporaryUrl($ruta, now()->addMinutes(5));
            return $url;
        } else {
            Log::error("El archivo no existe en S3: $ruta");
            return null;
        }
    }
}
