<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContratoFechas extends Model
{
    use HasFactory;

    protected $table = 'contrato_fechas';

    protected $fillable = [
        'contrato_id',
        'fecha_solicitud',
        'fecha_aprobacion',
        'fecha_rechazo',
        'fecha_anulacion',
        'fecha_entrega',
        'fecha_baja',
        'fecha_recogida',
        'fecha_finalizado',
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }
}
