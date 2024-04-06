<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property $user_id
 * @property $name
 * @property $surname
 * @property $dni
 * @property $edad
 * @property $primer_ingreso
 * @property $origen
 * @property $active
 * */
class Paciente extends Model
{
    use HasFactory;

    const ORIGEN = [
        '1' => 'nulo',
        '2' => 'Consulta Externa',
        '3' => 'UDO',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'dni',
        'edad',
        'primer_ingreso',
        'origen',
        'active',
    ];

    //Relaciones
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function contratos(){
        return $this->hasMany(Contrato::class);
    }

    public function contrato()
    {
        return $this->hasOne(Contrato::class)->latest('id');
    }

    public function hospital(){
        return $this->belongsToThrough(Hospital::class, User::class);
    }

}
