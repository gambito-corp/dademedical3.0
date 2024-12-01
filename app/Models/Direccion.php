<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direccion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'direcciones';

    protected $fillable = [
        'contrato_id',
        'distrito',
        'calle',
        'referencia',
        'responsable',
        'fecha_cambio',
        'active'
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }
}
