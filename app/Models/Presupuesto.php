<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;




class Presupuesto extends Model
{
    /** @use HasFactory<\Database\Factories\PresupuestoFactory> */
    use HasFactory;
    //Relación con clientes
    //Este presupuesto pertenece a un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación con líneas presupuesto
     * Un presupuesto tiene varias líneas de desglose de presupuesto
     */
     public function lineasPresupuestos():HasMany
    {
        return $this->hasMany(LineaPresupuesto::class); 
    }
}
