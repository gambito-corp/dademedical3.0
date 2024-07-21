<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasProfilePhoto,
        HasRoles,
        softDeletes,
        TwoFactorAuthenticatable;

    protected $fillable = [
        'hospital_id',
        'name',
        'surname',
        'password',
        'username',
        'email',
        'activo',
        'email_verified_at',
        'remember_token',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where($field ?? $this->getRouteKeyName(), $value)->firstOrFail();
    }
    /*ACCESORES*/
    public function getObtenerNombreAttribute()
    {
        return $this->name;
    }
    public function getRelacionRolesAttribute()
    {
        $roles = optional($this->roles);

        if ($roles->isEmpty()) {
            return 'No tiene Rol';
        }

        return $roles->pluck('name')->implode(', ');
    }
    public function getVerificacionBoleanoAttribute()
    {
        return $this->email_verified_at ? 'Si esta Verificado' : 'Falta Verificar';
    }

    /*SCOPES*/
    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeInactive($query)
    {
        return $query->whereNull('email_verified_at');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        });
    }
    /*RELACIONES*/

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function Logs()
    {
        return $this->hasMany(Logs::class);
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

    public function contratosSolicitados()
    {
        return $this->hasMany(ContratoUsuario::class, 'solicitante_id');
    }

    public function contratosAprobados()
    {
        return $this->hasMany(ContratoUsuario::class, 'aprobador_id');
    }

    public function contratosBajados()
    {
        return $this->hasMany(ContratoUsuario::class, 'bajador_id');
    }

    public function contratosFinalizados()
    {
        return $this->hasMany(ContratoUsuario::class, 'finalizador_id');
    }
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /*OVERRIDES*/

    public function sendEmailVerificationNotification(string $originalPasword = '')
    {
        $this->notify(new CustomVerifyEmail($originalPasword));
    }

}
