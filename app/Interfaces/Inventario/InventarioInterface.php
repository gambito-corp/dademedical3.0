<?php

namespace App\Interfaces\Inventario;

interface InventarioInterface
{

    public function query(string $orderColumn, mixed $ordenDirection);
}
