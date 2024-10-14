<?php

namespace App\Interfaces\Contrato;

interface ContratoInterface
{
    public function getContrato();
    public function getContratoById($id);
    public function save($data);

    public function query(string $orderColumn, string $orderDirection);
}
