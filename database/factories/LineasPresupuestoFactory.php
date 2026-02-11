<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lineas_presupuesto>
 */
class LineasPresupuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'precio' =>fake()->randomFloat(2,200,3000),
            'cantidad' =>fake()->numberBetween(1,100),
            //TODO INCLUIR PRESUPUESTO_ID Y PRODUCTO_ID
        ];
    }
}
