<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['codigo', 'contrato_id', 'activo', 'fecha_mantenimiento'];

    public function getEstadoAttribute()
    {
        if ($this->activo) {
            return 'Almacen';
        } elseif ($this->contrato_id) {
            return 'Alquilado';
        } elseif (!$this->activo) {
            return 'Mantenimiento';
//        } elseif(!$this->activo && ) {
//            return 'Retirado';
        }
    }

    public function productable()
    {
        return $this->morphTo();
    }
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
