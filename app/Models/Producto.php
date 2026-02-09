<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    /**
     * Relación con líneas_presupuesto
     * Un producto puede aparecer en muchas líneas de presupuesto
     */
    public function lineasPresupuestos():HasMany
    {
        return $this->hasMany(LineaPresupuesto::class); 
    }
    
}
