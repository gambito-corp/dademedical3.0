<?php

namespace App\Interfaces\Direccion;

interface DireccionInterface
{
    public function getDireccion();
    public function getDireccionById($id);
    public function save($data);
    public function update($data, $id);
    public function delete($id);
}
