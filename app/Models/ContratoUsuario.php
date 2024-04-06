<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ContratoUsuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contrato_usuarios';

    protected $fillable = [
        'contrato_id',
        'solicitante_id',
        'aprobador_id',
        'bajador_id',
        'finalizador_id'
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }

    public function solicitante(){
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function aprobador(){
        return $this->belongsTo(User::class, 'aprobador_id');
    }

    public function bajador(){
        return $this->belongsTo(User::class, 'bajador_id');
    }

    public function finalizador(){
        return $this->belongsTo(User::class, 'finalizador_id');
    }
}
