<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class LineaPresupuesto extends Model
{
    /** @use HasFactory<\Database\Factories\LineasPresupuestoFactory> */
    use HasFactory;

    /**
     * Relación con productos
     * Cada línea pertenece a un producto
     */

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con presupuesto
     * Cada línea pertenece a un presupuesto
     */
    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }


}
