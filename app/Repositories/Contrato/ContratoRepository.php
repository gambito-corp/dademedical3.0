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

    public function getContrato()
    {}

    public function getContratoById($id)
    {}

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

        return $contrato->load('contratoUsuario', 'contratoFechas');
    }
}
