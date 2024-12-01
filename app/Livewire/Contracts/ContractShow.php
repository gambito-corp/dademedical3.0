<?php

namespace App\Livewire\Contracts;

use App\Models\Archivo;
use App\Models\Contrato;
use App\Services\Archivo\ArchivoService;
use Hashids\Hashids;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\On;

class ContractShow extends Component
{
    public Contrato $contract;
    protected ArchivoService $archivoService;

    public bool $showDocument = false;
    public string $document = '';
    public string $urlImagen = '';
    public string $typeDocument = '';
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
        $type = Archivo::query()->find($filename);
        $extension = strtolower(pathinfo($type->nombre, PATHINFO_EXTENSION));
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'])) {
            $this->typeDocument = 'imagen';
        } elseif ($extension === 'pdf') {
            $this->typeDocument = 'pdf';
        }
        $hash = new Hashids();
        $this->urlImagen = $hash->encode($filename);
    }

    public function closeModal()
    {
        $this->showDocument = false;
        $this->document = '';
        $this->urlImagen = '';
    }
}
