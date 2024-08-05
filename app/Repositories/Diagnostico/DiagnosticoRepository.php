<?php

namespace App\Repositories\Diagnostico;

use App\Interfaces\Diagnostico\DiagnosticoInterface;
use App\Models\Diagnostico;

class DiagnosticoRepository implements DiagnosticoInterface
{
    public function __construct(private Diagnostico $diagnostico){}

    public function getDiagnostico()
    {}

    public function getDiagnosticoById($id)
    {}

    public function save($data)
    {
        return $this->diagnostico->create($data);
    }

    public function update($data, $id)
    {}

    public function delete($id)
    {}
}
