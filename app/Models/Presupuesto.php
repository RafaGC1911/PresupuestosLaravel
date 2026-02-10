<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;




class Presupuesto extends Model
{

    //Fillable
    protected $fillable = [
        'cliente_id',
        'user_id',
        'fecha',
        'total',
        'estado',
    ];

    //Casts

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
            'total' => 'float'
        ];
    }


    /** @use HasFactory<\Database\Factories\PresupuestoFactory> */
    use HasFactory;
    //Relación con clientes
    //Este presupuesto pertenece a un cliente
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación usuarios
     * Este presupuesto pertenece a un usuario que lo ha creado
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Relación con líneas presupuesto
     * Un presupuesto tiene varias líneas de desglose de presupuesto
     */
    public function lineasPresupuestos(): HasMany
    {
        return $this->hasMany(LineaPresupuesto::class);
    }
}
