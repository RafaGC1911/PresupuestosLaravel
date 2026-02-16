<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presupuesto>
 */
class PresupuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => fake()->dateTime(),
            'total' => fake()->randomFloat(2, 200, 4000),
            //Inserta un dato random entre estos 3 posibilidades
            'estado' => fake()->randomElement([
                'pendiente',
                'aceptado',
                'rechazado'
            ]),
            'cliente_id' => \App\Models\Cliente::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
