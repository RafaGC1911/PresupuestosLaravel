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
            'fecha'=>fake()->dateTime(),
            'total' =>fake()->randomFloat(2,200,4000),
            'estado' =>fake()->word(),
            //TODO INCLUIR CLIENTE Y USER ID
        ];
    }
}
