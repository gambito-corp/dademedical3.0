<?php

namespace App\Repositories\Inventario;

use App\Interfaces\Inventario\InventarioInterface;

use App\Models\Producto;
use App\Services\Logs\LogService;

class InventarioRepository implements InventarioInterface
{

    public function __construct(
        protected Producto $product,
        protected LogService $logService
    )
    {

    }
    public function query(string $orderColumn = 'id', mixed $ordenDirection = 'desc')
    {
        $query = $this->product->newQuery();
        $query = $query->with('productable', 'contrato.paciente');
        return $query->orderBy($orderColumn, $ordenDirection);
    }
}
