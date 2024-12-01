<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnostico extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'contrato_id',
        'historia_clinica',
        'diagnostico',
        'dosis',
        'frecuencia',
        'comentarios',
        'active',
        'fecha_cambio',
    ];

    // Mutador para dosis
    public function setDosisAttribute($value)
    {
        // Limpiar la cadena y convertir a double
        $dosis = $this->sanitizeDosis($value);

        // Asegurar que la dosis esté en el rango permitido
        $dosis = max(0.50, min(10.00, $dosis));

        $this->attributes['dosis'] = $dosis;
    }

    // Accesor para dosis
    public function getDosisAttribute($value)
    {
        // Mostrar como string seguido de ' LPM'
        return number_format($value, 2) . ' LPM';
    }

    // Mutador para frecuencia
    public function setFrecuenciaAttribute($value)
    {
        // Guardar como integer
        $this->attributes['frecuencia'] = (int) $value;
    }

    // Accesor para frecuencia
    public function getFrecuenciaAttribute($value)
    {
        // Mostrar como string seguido de ' horas'
        return $value . ' horas';
    }

    private function sanitizeDosis($value)
    {
        // Remover espacios y convertir a minúsculas
        $value = strtolower(trim($value));

        // Reemplazar diferentes separadores de intervalos por comas
        $value = str_replace(['-', '/', 'a', ' '], ',', $value);

        // Dividir en partes usando coma como separador
        $parts = explode(',', $value);

        // Filtrar y convertir las partes a números
        $numbers = array_filter(array_map('floatval', $parts));

        // Si hay múltiples números, tomar el máximo
        $dosis = !empty($numbers) ? max($numbers) : 0.0;

        return $dosis;
    }
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
