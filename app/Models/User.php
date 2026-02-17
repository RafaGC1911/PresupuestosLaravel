<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Constantes
     * 
     */

    const ROL_ADMIN = 'admin';
    const ROL_COMERCIAL = 'comercial';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    //Relación con presupuesto
    //Un usuario puede hacer muchos presupuestos
    public function presupuestos(): HasMany
    {
        return $this->hasMany(Presupuesto::class);
    }
}

/**
 * Funciones para verficar si el usuario es admin o comercial.
 * Se usarán luego en DashboardController
 */

// public function isAdmin(){

// }