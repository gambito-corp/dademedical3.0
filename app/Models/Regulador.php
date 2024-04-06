<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulador extends Model
{
    use HasFactory;

    protected $table = 'reguladores';
    protected $fillable = ['capacidad'];
    public function producto()
    {
        return $this->morphOne(Producto::class, 'productable');
    }
}
