<?php
namespace App\Livewire\Incidences;

use App\Models\Carrito;
use App\Models\Concentrador;
use App\Models\Producto;
use App\Models\Regulador;
use App\Models\Tanque;
use App\Services\Incidencia\IncidenciaService;
use Livewire\Component;
use Livewire\Attributes\Validate;

class EditIncidence extends Component
{
    protected IncidenciaService $incidenciaService;

    public $incidenceId;
    #[Validate('required|in:fallo de maquina,fallo de accesorio,fallo de manipulacion,otros')]
    public $tipo_incidencia;

    #[Validate('required')]
    public $incidencia;

    #[Validate('nullable')]
    public $respuesta;

    #[Validate('nullable')]
    public $cambio_concentrador;
    #[Validate('nullable')]
    public $concentrador;

    #[Validate('nullable')]
    public $cambio_tanque;
    #[Validate('nullable')]
    public $tanque;

    #[Validate('nullable')]
    public $cambio_regulador;
    #[Validate('nullable')]
    public $regulador;

    #[Validate('nullable')]
    public $cambio_carrito;
    #[Validate('nullable')]
    public $carrito;

    #[Validate('nullable')]
    public $envio_consumible;

    #[Validate('nullable')]
    public $archivo_resolucion;

    #[Validate('boolean')]
    public $active;

    public $concentradorCodigo;
    public $tanqueCodigo;
    public $reguladorCodigo;
    public $carritoCodigo;

    public $concentradoresBusqueda = [];
    public $tanquesBusqueda = [];
    public $reguladoresBusqueda = [];
    public $carritosBusqueda = [];

    public function boot(IncidenciaService $incidenciaService): void
    {
        $this->incidenciaService = $incidenciaService;
    }

    public function mount($incidenceId)
    {
        $this->incidenceId = $incidenceId;
        $incidence = $this->incidenciaService->findWithTrashed($incidenceId);
        $this->tipo_incidencia = $incidence->tipo_incidencia;
        $this->incidencia = $incidence->incidencia;
        $this->respuesta = $incidence->respuesta;
        $this->active = !(bool)$incidence->active;
        // Carga tipos de resolución si existen
        // $this->cambio_maquina = $incidence->cambio_maquina;
        // ...
    }

    public function render()
    {
        $concentradores = Producto::query()->where('productable_type', 'Concentrador')->get();
        $tanques = Producto::query()->where('productable_type', 'Tanque')->get();
        $reguladores = Producto::query()->where('productable_type', 'Regulador')->get();
        $carritos = Producto::query()->where('productable_type', 'Carrito')->get();

        return view('livewire.incidences.edit-incidence', compact('concentradores', 'tanques', 'reguladores', 'carritos'));
    }

    public function updatedConcentradorCodigo()
    {
        $this->buscarConcentrador();
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

    public function buscarConcentrador()
    {
        $this->concentradoresBusqueda = Producto::query()
            ->where('productable_type', 'Concentrador')
            ->where('codigo', 'like', '%' . $this->concentradorCodigo . '%')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function buscarTanque()
    {
        $this->tanquesBusqueda = Producto::query()
            ->where('productable_type', 'Tanque')
            ->where('codigo', 'like', '%' . $this->tanqueCodigo . '%')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function buscarRegulador()
    {
        $this->reguladoresBusqueda = Producto::query()
            ->where('productable_type', 'Regulador')
            ->where('codigo', 'like', '%' . $this->reguladorCodigo . '%')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function buscarCarrito()
    {
        $this->carritosBusqueda = Producto::query()
            ->where('productable_type', 'Carrito')
            ->where('codigo', 'like', '%' . $this->carritoCodigo . '%')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function seleccionarConcentrador($id)
    {
        $this->concentrador = $id;
        $this->concentradorCodigo = Producto::find($id)->codigo;
        $this->concentradoresBusqueda = [];
    }

    public function seleccionarTanque($id)
    {
        $this->tanque = $id;
        $this->tanqueCodigo = Producto::find($id)->codigo;
        $this->tanquesBusqueda = [];
    }

    public function seleccionarRegulador($id)
    {
        $this->regulador = $id;
        $this->reguladorCodigo = Producto::find($id)->codigo;
        $this->reguladoresBusqueda = [];
    }

    public function seleccionarCarrito($id)
    {
        $this->carrito = $id;
        $this->carritoCodigo = Producto::find($id)->codigo;
        $this->carritosBusqueda = [];
    }

    public function updateIncidence()
    {
        try {
            $validated = $this->validate();
            $data = [
                'id' => $this->incidenceId,
                'tipo_incidencia' => $this->tipo_incidencia,
                'incidencia' => $this->incidencia,
                'respuesta' => $this->respuesta,
                'active' => $this->active,
                'cambio_concentrador' => $this->cambio_concentrador,
                'concentrador' => $this->concentrador,
                'cambio_tanque' => $this->cambio_tanque,
                'tanque' => $this->tanque,
                'cambio_regulador' => $this->cambio_regulador,
                'regulador' => $this->regulador,
                'cambio_carrito' => $this->cambio_carrito,
                'carrito' => $this->carrito,
                'envio_consumible' => $this->envio_consumible,
            ];

            if ($this->archivo_resolucion) {
                // Sube el archivo y guarda la ruta en la base de datos
                $archivoPath = $this->archivo_resolucion->store('resoluciones', 'public');
                $data['archivo_resolucion'] = $archivoPath;
            }

            $this->incidenciaService->update($data);
            $this->dispatch('closeModal', 'edit', $this->incidenceId);
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('validation_errors', $e->errors());
            // No cerrar el modal si hay errores
            // $this->dispatch('closeModal', 'edit', $this->incidenceId);
        }
    }
}
