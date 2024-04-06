<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

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

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
