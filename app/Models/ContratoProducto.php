<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoProducto extends Model
{
    protected $table = 'contrato_productos';
    protected $fillable = ['contrato_id', 'producto_id'];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
