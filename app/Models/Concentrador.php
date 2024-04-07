<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concentrador extends Model {
    use HasFactory;

    protected $table = 'concentradores';

    protected $fillable = ['capacidad', 'marca', 'modelo'];

    public function producto() {
        return $this->morphOne(Producto::class, 'productable');
    }

}
