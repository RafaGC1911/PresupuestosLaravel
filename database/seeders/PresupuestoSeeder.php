<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Aquí cargamos todos los productos para poder usarlos después si hace falta
         * Como un select * from tabla
         */
        $productos = Producto::all();
        $clientes = Cliente::all();
        $usuarios = User::where('rol', 'comercial')->get();

        $clientes->each(function ($cliente) use ($productos, $usuarios){
            $presupuesto = Presupuesto::create([
                'cliente_id' => $cliente->id,
                'user_id' => $usuarios->random()->id,
                'fecha' => fake()->date(),
                'total' => fake()->randomFloat(2, 300, 8000),
                'estado' =>fake()->randomElement([
                'pendiente',
                'aceptado',
                'rechazado'
            ])
            ]);
        });

    

        //  $table->id();
        //     $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
        //     $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        //     $table->date('fecha');
        //     $table->float('total');
        //     $table->string('estado');
        //     $table->timestamps();
    }
}
