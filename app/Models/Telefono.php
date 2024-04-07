<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'numero',
        'tipo'
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }
}
