<?php

namespace App\Repositories\Contrato;

use App\Interfaces\Contrato\ContratoInterface;
use App\Models\Contrato;
use App\Models\ContratoFechas;
use App\Models\ContratoUsuario;
use Illuminate\Support\Facades\Auth;

class ContratoRepository implements ContratoInterface
{

    public function __construct(private Contrato $contrato)
    {
    }

    public function query(string $orderColumn, string $orderDirection)
    {
        $query = $this->contrato->newQuery();
        return $query->orderBy($orderColumn, $orderDirection);
    }




    public function getContrato()
    {}

    public function getContratoById($id)
    {
        return $this->contrato->query()->find($id);
    }

    public function save($data)
    {
        $contrato = $this->contrato->create($data);
        $contratoUsuario = new ContratoUsuario();
        $contratoFechas = new ContratoFechas();

        $contratoUsuario->contrato_id = $contrato->id;
        $contratoUsuario->solicitante_id = Auth::id();
        $contratoUsuario->save();

        $contratoFechas->contrato_id = $contrato->id;
        $contratoFechas->fecha_solicitud = now();
        $contratoFechas->save();

        return $contrato->load('contratoUsuario', 'contratoFechas');
    }


}
