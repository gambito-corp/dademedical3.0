<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contrato extends Model
{
    use HasFactory;

    const ESTADO_ORDEN = [
        0 => 'OS Solicitado',
        1 => 'OS Aprobado',
        2 => 'OS Rechazado',
        3 => 'OS Anulado',
        4 => 'OS Entregado',
        5 => 'OS Recojo',
        6 => 'OS Finalizado',
    ];

    protected $fillable = [
        'paciente_id',
        'estado_orden',
        'traqueotomia',
        'motivo_alta',
        'comentario_alta',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function archivos()
    {
        return $this->belongsToMany(Archivo::class, 'contrato_archivos', 'contrato_id', 'archivo_id')
            ->withTimestamps();
    }

    public function diagnosticos()
    {
        return $this->hasMany(Diagnostico::class);
    }
    public function diagnostico()
    {
        return $this->hasOne(Diagnostico::class)->latest('id');
    }
    public function diagnosticosPendientes()
    {
        return $this->diagnosticos()->where('active', 0);
    }
    public function diagnosticosAprobados()
    {
        return $this->diagnosticos()->where('active', 1);
    }
    public function ultimoDiagnosticoPendiente()
    {
        return $this->diagnosticosPendientes()->latest('id')->first();
    }
    public function ultimoDiagnosticoAprobado()
    {
        return $this->diagnosticosAprobados()->latest('id')->first();
    }


    public function direccion()
    {
        return $this->hasOne(Direccion::class)->latest('id');
    }

    public function telefonos()
    {
        return $this->hasMany(Telefono::class);
    }
    public function contratoUsuario()
    {
        return $this->hasOne(ContratoUsuario::class);
    }
    public function contratoFechas()
    {
        return $this->hasOne(ContratoFechas::class);
    }

    // Relación con la tabla contrato_productos
    public function productos(): HasMany
    {
        return $this->hasMany(ContratoProducto::class);
    }
}
