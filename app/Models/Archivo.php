<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'archivos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['contrato_id', 'nombre', 'ruta'];


    /**
     * Get the contrato that owns the archivo.
     */
    public function contratos(){
        return $this->belongsToMany(Contrato::class, 'contrato_archivos');
    }
}
