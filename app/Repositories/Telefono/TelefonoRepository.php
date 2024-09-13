<?php

namespace App\Repositories\Telefono;

use App\Interfaces\Telefono\TelefonoInterface;
use App\Models\Telefono;

class TelefonoRepository implements TelefonoInterface
{

    public function __construct(private Telefono $telefono)
    {
    }

    public function getTelefono()
    {
    }

    public function getTelefonoById($id)
    {
    }

    public function save($data, $id)
    {
        foreach ($data as $tel) {
            $this->telefono->create([
                'contrato_id' => $id,
                'numero' => $tel,
                'tipo' => 'personal'
            ]);
        }
    }

    public function update($data, $id)
    {
    }

    public function delete($id)
    {
        $this->telefono->query()->where('id', $id)->delete();
    }
}

