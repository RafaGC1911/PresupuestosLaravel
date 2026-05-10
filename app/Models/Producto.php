<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    //Fillable
    protected $fillable = [
        'tipo',
        'precio_base',
        'imagen'//Agregar imagen
    ];

    //Cast para que precio siempre sea un tipo float

    protected function casts(): array
    {
        return [
             'precio_base' => 'float',
        ];
    }
    


    /**
     * Relación con líneas_presupuesto
     * Un producto puede aparecer en muchas líneas de presupuesto
     * 
     * Le dice a Laravel:
     *  Busca todas las líneas_presupuesto cuyo producto_id coincida con este producto.
     * 
     * 
     */
    public function lineasPresupuestos():HasMany
    {
        return $this->hasMany(LineaPresupuesto::class); 
    }
}
