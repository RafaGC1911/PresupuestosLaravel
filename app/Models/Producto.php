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
     */
    public function lineasPresupuestos():HasMany
    {
        return $this->hasMany(LineaPresupuesto::class); 
    }
}
