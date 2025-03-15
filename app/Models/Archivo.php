<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $table = 'archivos';

    protected $fillable = ['contrato_id', 'paciente_id', 'nombre', 'ruta', 'tipo'];

    // Definición de los tipos de archivo como constantes
    const TIPO_SOLICITUD_OXIGENOTERAPIA = 'solicitud de oxigenoterapia';
    const TIPO_DNI_PACIENTE = 'dni paciente';
    const TIPO_DNI_CUIDADOR = 'dni cuidador';
    const TIPO_DECLARACION_DOMICILIO = 'declaracion jurada de domicilio';
    const TIPO_CROQUIS_DIRECCION = 'croquis de direccion';
    const TIPO_OTROS = 'otros';
    const TIPO_ENTREGA_DISPOSITIVOS = 'documento de entrega de dispositivos';
    const TIPO_GUIA_REMISION = 'guia de remision';
    const TIPO_CAMBIO_CONSUMIBLE = 'documento de cambio de consumible';
    const TIPO_CAMBIO_MAQUINA = 'documento de cambio de maquina';
    const TIPO_CAMBIO_DOSIS = 'documento de cambio de dosis';
    const TIPO_CAMBIO_DIRECCION = 'documento de cambio de direccion';
    const TIPO_INFORME_INCIDENCIA = 'informe de incidencia';
    const TIPO_RESPUESTA_INCIDENCIA = 'respuesta de incidencia';
    const TIPO_RECOJO_DISPOSITIVOS = 'documento de recojo de dispositivos';
    const TIPO_RESOLUCION_INCIDENCIA = 'resolucion de incidencia';

    public function contratos()
    {
        return $this->belongsToMany(Contrato::class, 'contrato_archivos', 'archivo_id', 'contrato_id')
            ->withTimestamps();
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
}
