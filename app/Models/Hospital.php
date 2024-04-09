<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['nombre', 'acronimo', 'direccion', 'parent_id', 'estado'];

//    protected $appends = ['parent'];

    public function parent()
    {
        return $this->belongsTo(Hospital::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Hospital::class, 'parent_id');
    }
    public function personal()
    {
        return $this->hasMany(User::class, 'hospital_id');
    }

    public function pacientes()
    {
        return $this->hasManyThrough(Paciente::class, User::class, 'hospital_id', 'user_id');
    }
}
