<?php

namespace App\Livewire\Contracts\Forms;

use App\Models\Carrito;
use App\Models\Concentrador as Maquina;
use App\Models\Contrato;
use App\Models\ContratoUsuario;
use App\Models\Producto;
use App\Models\ContratoProducto;
use App\Models\Regulador;
use App\Models\Tanque;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

use App\Exports\FichaInstalacionExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;



class OsSolicitado extends Component
{
    public Contrato $contract;

    // Variables de formulario
    public null|int|Producto $maquina = null;
    public null|int|Producto $tanque = null;
    public null|int|Producto $regulador = null;
    public null|int|Producto $carrito = null;

    public array $maquinas = [];
    public array $tanques = [];
    public array $reguladores = [];
    public array $carritos = [];

    public string $maquinaCodigo = '';
    public string $tanqueCodigo = '';
    public string $reguladorCodigo = '';
    public string $carritoCodigo = '';

    // Variables de control
    public bool $showDownloadButton = false;
    public bool $showApproveButton = false;

    public function mount(Contrato $contract)
    {
        $this->contract = $contract;
    }

    public function updatedMaquinaCodigo()
    {
        $this->buscarMaquina();
    }
    public function updatedTanqueCodigo()
    {
        $this->buscarTanque();
    }

    public function updatedReguladorCodigo()
    {
        $this->buscarRegulador();
    }

    public function updatedCarritoCodigo()
    {
        $this->buscarCarrito();
    }


    public function buscarMaquina()
    {
        $this->maquinas = Producto::query()
            ->where('productable_type', Maquina::class)
            ->where('codigo', 'like', '%' . $this->maquinaCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarMaquina($codigo)
    {
        $this->maquina = Producto::query()
            ->where('id', $codigo)
            ->with('productable')
            ->first();
        $this->maquinaCodigo = $this->maquina->codigo;
        $this->maquinas = [];
        $this->checkButtonsVisibility();
    }
    public function buscarTanque()
    {
        $this->tanques =  Producto::query()
            ->where('productable_type', Tanque::class)
            ->where('codigo', 'like', '%' . $this->tanqueCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarTanque($codigo)
    {
        $this->tanque = Producto::query()
            ->where('id', $codigo)
            ->with('productable')
            ->first();
        $this->tanqueCodigo = $this->tanque->codigo;
        $this->tanques = [];
    }
    public function buscarRegulador()
    {
        $this->reguladores = Producto::query()
            ->where('productable_type', Regulador::class)
            ->where('codigo', 'like', '%' . $this->reguladorCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarRegulador($codigo)
    {
        $this->regulador = Producto::query()
            ->where('id', $codigo)
            ->with('productable')
            ->first();
        $this->reguladorCodigo = $this->regulador->codigo;
        $this->reguladores = [];
    }
    public function buscarCarrito()
    {
        $this->carritos = Producto::query()
            ->where('productable_type', Carrito::class)
            ->where('codigo', 'like', '%' . $this->carritoCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarCarrito($codigo)
    {
        $this->carrito = Producto::query()
            ->where('id', $codigo)
            ->with('productable')
            ->first();
        $this->carritoCodigo = $this->carrito->codigo;
        $this->carritos = [];
    }
    private function checkButtonsVisibility()
    {
        if ($this->maquina) {
            $this->showDownloadButton = true;
        } else {
            $this->showDownloadButton = false;
            $this->showApproveButton = false;
        }
    }

    // Acción al hacer clic en "Descargar Ficha de Instalación"
    public function downloadInstallationSheet()
    {
        // Preparar los datos del contrato y los productos
        $productos = [
            'maquina' => $this->maquina,
            'tanque' => $this->tanque,
            'regulador' => $this->regulador,
            'carrito' => $this->carrito,
        ];

        // Crear una instancia del exportador
        $export = new FichaInstalacionExport($this->contract, $productos);

        $patientName = Str::slug($this->contract?->paciente?->full_name, '_');

        // Definir el nombre del archivo de salida
        $outputFilename = 'Ficha_Instalacion_'.$patientName.'.xlsx';

        // Guardar el archivo Excel
        $export->saveSpreadsheet($outputFilename);

        // Definir la ruta completa del archivo para descargar
        $outputPath = storage_path('app/templates/output/' . $outputFilename);

        // Retornar la descarga al usuario
        if (file_exists($outputPath)) {
            $this->showDownloadButton = false;
            $this->showApproveButton = true;
            return response()->download($outputPath)->deleteFileAfterSend(true);
        } else {
            abort(404, 'El archivo no se pudo generar');
        }
    }

    // Acción al hacer clic en "Aprobar OS"
    public function approveOS()
    {
//        // Validar que los campos requeridos estén llenos
        $this->validate([
            'maquina' => 'required',
            'tanque' => 'nullable',
            'regulador' => 'nullable',
            'carrito' => 'nullable',
        ]);
        try {
            DB::beginTransaction();//        // Actualizar el estado del contrato
            $this->contract->estado_orden = 1;
            $this->contract->save();
            // Asociar los productos al contrato
            if($this->maquina) $this->asignarProductoAlContrato($this->maquina->id);

            if($this->tanque) $this->asignarProductoAlContrato($this->tanque->id);

            if($this->regulador) $this->asignarProductoAlContrato($this->regulador->id);

            if($this->carrito) $this->asignarProductoAlContrato($this->carrito->id);

            // Actualizar fecha de aprobación
            $anotarFecha = $this->contract->contratoFechas()->first();
            if ($anotarFecha) {
                $anotarFecha->fecha_aprobacion = now();
                $anotarFecha->save();
            }
            //Actualiza Id De Usuario Aprobador
            $this->contract->contratoUsuario->aprobador_id = auth()->user()->id;
            $this->contract->contratoUsuario->save();
            DB::commit();
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
        session()->flash('status', 'La Orden de Servicio ha sido aprobada.');
    }

    // Acción al hacer clic en "Rechazar OS"
    public function rejectOS()
    {
        try{
            DB::beginTransaction();
            // Actualizar el estado del contrato
            $this->contract->estado_orden = 2;
            $this->contract->save();
            // Actualizar fecha de rechazo
            $this->contract->contratoFechas->fecha_rechazo = now();
            $this->contract->contratoFechas->save();

            //borrar registro de usuario aprobador
            $registroUsuarioAprobador = ContratoUsuario::query()
                ->where('contrato_id', $this->contract->id)
                ->get()
                ->last();
            $registroUsuarioAprobador->delete();
            DB::commit();
            $this->dispatch('orden-actualizada', ['contractId' => $this->contract->id]);
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
        session()->flash('status', 'La Orden de Servicio ha sido rechazada.');
    }

    private function asignarProductoAlContrato(int $productoId)
    {
        $producto = Producto::query()->find($productoId);
        if ($producto) {
            $producto->contrato_id = $this->contract->id;
            $producto->save();

            $vinculacionPivote = new ContratoProducto();
            $vinculacionPivote->contrato_id = $this->contract->id;
            $vinculacionPivote->producto_id = $productoId;
            $vinculacionPivote->save();
        }
    }

    public function render()
    {
        return view('livewire.contracts.forms.os-solicitado');
    }
}
