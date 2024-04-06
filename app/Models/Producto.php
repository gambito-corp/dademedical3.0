<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['codigo', 'contrato_id', 'activo', 'fecha_mantenimiento'];
    public function productable()
    {
        return $this->morphTo();
    }
}
