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

    protected $cast = [
        'fecha_solicitud' => 'datetime',
        'fecha_aprobacion' => 'datetime',
        'fecha_rechazo' => 'datetime',
        'fecha_anulacion' => 'datetime',
        'fecha_entrega' => 'datetime',
        'fecha_baja' => 'datetime',
        'fecha_recogida' => 'datetime',
        'fecha_finalizado' => 'datetime',
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }
}
