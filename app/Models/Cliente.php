<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cliente extends Model
{
    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;

    //Relación con presupuestos
    //Un cliente puede tener varios presupuestos
    public function presupuestos():HasMany
    {
        return $this->hasMany(Presupuesto::class); 
    }

    //Fillables
     protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion'
    ];

    
}
