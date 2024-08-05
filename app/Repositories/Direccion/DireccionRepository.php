<?php

namespace App\Repositories\Direccion;

use App\Interfaces\Direccion\DireccionInterface;
use App\Models\Direccion;
use Illuminate\Database\Eloquent\Collection;

class DireccionRepository implements DireccionInterface
{

    public function __construct(private Direccion $direccion)
    {
    }

    public function getDireccion()
    {}

    public function getDireccionById($id)
    {}

    public function save($data): Direccion|Collection|null
    {
        return $this->direccion->create($data);
    }

    public function update($data, $id)
    {}

    public function delete($id)
    {}
}
