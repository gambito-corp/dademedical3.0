<?php

namespace App\Livewire\Contracts\Forms;

use App\Models\Carrito;
use App\Models\Concentrador as Maquina;
use App\Models\Contrato;
use App\Models\Producto;
use App\Models\ContratoProducto;
use App\Models\Regulador;
use App\Models\Tanque;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

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
            ->first();
        $this->maquinaCodigo = $this->maquina->codigo;
        $this->maquinas = [];
        $this->checkButtonsVisibility();
    }
    public function buscarTanque()
    {
        $this->tanques =  Producto::query()
            ->where('productable_type', Tanque::class)
            ->where('codigo', 'like', '%' . $this->maquinaCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarTanque($codigo)
    {
        $this->tanque = Producto::query()
            ->where('id', $codigo)
            ->first();
        $this->tanqueCodigo = $this->tanque->codigo;
        $this->tanques = [];
    }
    public function buscarRegulador()
    {
        $this->reguladores = Producto::query()
            ->where('productable_type', Regulador::class)
            ->where('codigo', 'like', '%' . $this->maquinaCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarRegulador($codigo)
    {
        $this->regulador = Producto::query()
            ->where('id', $codigo)
            ->first();
        $this->reguladorCodigo = $this->regulador->codigo;
        $this->reguladores = [];
    }
    public function buscarCarrito()
    {
        $this->carritos = Producto::query()
            ->where('productable_type', Carrito::class)
            ->where('codigo', 'like', '%' . $this->maquinaCodigo . '%')
            ->where('activo', '1')
            ->take(10)
            ->get()
            ->toArray();
    }
    public function seleccionarCarrito($codigo)
    {
        $this->carrito = Producto::query()
            ->where('id', $codigo)
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
        // Lógica para generar y descargar la ficha de instalación
        // ...

        // Después de descargar, mostrar el botón de "Aprobar OS"
        $this->showApproveButton = true;
        $this->showDownloadButton = false;
    }

    // Acción al hacer clic en "Aprobar OS"
    public function approveOS()
    {
//        // Validar que los campos requeridos estén llenos
//        $this->validate([
//            'maquina' => 'required',
//            'tanque' => 'required',
//            'regulador' => 'required',
//            'carrito' => 'required',
//        ]);
//
//        // Actualizar el estado del contrato
//        $this->contract->estado_orden = 'aprove';
//        $this->contract->save();
//
//        // Asociar los productos al contrato
//        $this->asignarProductoAlContrato($this->maquina);
//        $this->asignarProductoAlContrato($this->tanque);
//        $this->asignarProductoAlContrato($this->regulador);
//        $this->asignarProductoAlContrato($this->carrito);
//
//        // Actualizar fecha de aprobación
//        $anotarFecha = $this->contract->contratoFechas()->first();
//        if ($anotarFecha) {
//            $anotarFecha->fecha_aprobacion = now();
//            $anotarFecha->save();
//        }
//
//        session()->flash('status', 'La Orden de Servicio ha sido aprobada.');
    }

    // Acción al hacer clic en "Rechazar OS"
    public function rejectOS()
    {
//        // Actualizar el estado del contrato
//        $this->contract->estado_orden = 'reject';
//        $this->contract->save();
//
//        // Actualizar fecha de rechazo
//        $anotarFecha = $this->contract->contratoFechas()->first();
//        if ($anotarFecha) {
//            $anotarFecha->fecha_rechazo = now();
//            $anotarFecha->save();
//        }
//
//        session()->flash('status', 'La Orden de Servicio ha sido rechazada.');
    }

    private function asignarProductoAlContrato(int $productoId)
    {
//        $producto = Producto::find($productoId);
//        if ($producto) {
//            $producto->contrato_id = $this->contract->id;
//            $producto->save();
//
//            $vinculacionPivote = new ContratoProducto();
//            $vinculacionPivote->contrato_id = $this->contract->id;
//            $vinculacionPivote->producto_id = $productoId;
//            $vinculacionPivote->save();
//        }
    }

    public function render()
    {
        return view('livewire.contracts.forms.os-solicitado');
    }
}
