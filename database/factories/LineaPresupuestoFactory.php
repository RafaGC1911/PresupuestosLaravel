<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lineas_presupuesto>
 */
class LineaPresupuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'precio' => fake()->randomFloat(2, 200, 3000),
            'cantidad' => fake()->numberBetween(1, 100),
            /**Para crear un presupuesto_id o un producto_id laravel primero llama a 
             * la factory de presupuesto y a la de producto, porque las líneas no pueden existir 
             * sin que haya antes un producto o un presupuesto, por eso laravel se asegura y si no existe, lo crea 
             * para no generar conflicto
             * Si no hay producto o presupuesto, laravel lo crea y le asigna su id.
             * Esto se hace con las factories porque son datos falsos y de prueba.
             */
            'presupuesto_id' => \App\Models\Presupuesto::factory(),
            'producto_id' => \App\Models\Producto::factory(),

        ];
    }
}
