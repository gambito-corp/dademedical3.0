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

    public function update($data)
    {
        return $data->save();
    }

    public function delete($id)
    {}

    public function deletePending(mixed $contrato_id)
    {
        $direccionPendiente = $this->direccion->where('contrato_id', $contrato_id)->where('active', 0)->get();
        foreach ($direccionPendiente as $direccion) {
            $direccion->forceDelete();
        }
    }
}
