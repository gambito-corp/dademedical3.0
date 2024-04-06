<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Tanque extends Model
{
    use HasFactory;

    protected $table = 'tanques';
    protected $fillable = ['capacidad'];

    public function producto()
    {
        return $this->morphOne(Producto::class, 'productable');
    }
}
