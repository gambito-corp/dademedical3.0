<?php

namespace App\Interfaces\Direccion;

interface DireccionInterface
{
    public function getDireccion();
    public function getDireccionById($id);
    public function save($data);
    public function update($data);
    public function delete($id);

    public function deletePending(mixed $contrato_id);
}
