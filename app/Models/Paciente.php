<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $user_id
 * @property $name
 * @property $surname
 * @property $dni
 * @property $edad
 * @property $primer_ingreso
 * @property $origen
 * @property $active
 * */
class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    const ORIGEN = [
        '1' => 'nulo',
        '2' => 'Consulta Externa',
        '3' => 'UDO',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'dni',
        'edad',
        'primer_ingreso',
        'origen',
        'active',
    ];
    protected $appends = [
        'diagnosticoPendiente', 'idDiagnosticoPendiente'
    ];

    //accesor
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }
    public function getOriginAttribute()
    {
        return $this->origen == 1 ? 'Consulta externa' : 'UDO';
    }

    // Accessor para diagnosticoPendiente
    public function getDiagnosticoPendienteAttribute()
    {
        $contrato = $this->contrato;

        if ($contrato) {
            // Verificamos si existen diagnósticos pendientes en el contrato
            return $contrato->diagnosticosPendientes()->exists();
        }

        return false;
    }

    // Accessor para idDiagnosticoPendiente
    public function getIdDiagnosticoPendienteAttribute()
    {
        // Solo si existe un diagnóstico pendiente
        if ($this->diagnosticoPendiente) {
            $contrato = $this->contrato;

            if ($contrato) {
                $diagnosticoPendiente = $contrato->diagnosticosPendientes()->first();

                if ($diagnosticoPendiente) {
                    return $diagnosticoPendiente->id;
                }
            }
        }

        return null;
    }

    //Relaciones

    // Relación para obtener todos los archivos de un paciente a través de los contratos
    public function archivos()
    {
        return $this->hasManyThrough(Archivo::class, Contrato::class, 'paciente_id', 'contrato_id', 'id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function contratos(){
        return $this->hasMany(Contrato::class);
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class)->latest('id');
    }
}
