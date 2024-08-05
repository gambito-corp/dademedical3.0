<?php

namespace App\Interfaces\Diagnostico;

interface DiagnosticoInterface
{
    public function getDiagnostico();
    public function getDiagnosticoById($id);
    public function save($data);
    public function update($data, $id);
    public function delete($id);
}
