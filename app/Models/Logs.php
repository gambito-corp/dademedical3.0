<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'user_id',
        'original_user_id',
        'ip_address',
        'url',
        'function',
        'accion',
        'method',
        'message',
        'level',
        'context', // Asegúrate de que tu base de datos pueda almacenar este campo como JSON correctamente.
        'comentario',
        'strackTrace', // Corrige según sea necesario.
    ];

    /**
     * Relación con el usuario que generó el log.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el usuario original en caso de acciones realizadas en nombre de otro usuario.
     */
    public function originalUser()
    {
        return $this->belongsTo(User::class, 'original_user_id');
    }
}
