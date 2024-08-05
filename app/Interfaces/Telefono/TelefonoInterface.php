<?php

namespace App\Interfaces\Telefono;

interface TelefonoInterface
{
    public function getTelefono();
    public function getTelefonoById($id);
    public function save($data, $id);
    public function update($data, $id);
    public function delete($id);
}
