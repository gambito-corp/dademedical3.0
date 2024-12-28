<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'contrato_id',
        'user_id',
        'responding_user_id',
        'tipo_incidencia',
        'incidencia',
        'respuesta',
        'active',
        'fecha_incidencia',
        'fecha_respuesta',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function respondingUser()
    {
        return $this->belongsTo(User::class, 'responding_user_id');
    }
}
