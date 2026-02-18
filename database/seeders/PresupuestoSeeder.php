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
        $usuarios = User::where('rol', User::ROL_COMERCIAL)->get();

        $clientes->each(function ($cliente) use ($productos, $usuarios){
            // Creo un presupuesto 
            $presupuesto = Presupuesto::create([
                //Relaciona el presupuesto con el cliente actual del bucle
                'cliente_id' => $cliente->id,
                //Elige un usuario comercial aleatorio
                'user_id' => $usuarios->random()->id,
                'fecha' => fake()->date(),
                //El total lo incio en 0 porque se va a calcular luego
                'total' => 0,
                //Asigna un estado aleatorio del presupuesto entre estas 3 opciones
                'estado' =>fake()->randomElement([
                'pendiente',
                'aceptado',
                'rechazado'
            ])
            ]);
            //Variable para ir almacenando el total real
            $total = 0;

            //Ahora hay que crear las líneas del presupuesto, le pongo un aleatorio entre 1 y 5 por ejemplo
            $lineas = fake()->numberBetween(1,5);

            for($i = 0; $i< $lineas; $i++){

            //Saco un producto aleatorio 
            $producto = $productos->random();

            //Genero una cantidad aleatoria también
             $cantidad = fake()->numberBetween(1, 10);

             //Me traigo el precio base del producto
             $precio = $producto->precio_base;

             //Con esto calculo el subtotal de esta línea
             $subtotal = $precio * $cantidad;

             //Creo la línea del presupuesto. Laravel la va a relacionar automáticamente con el presupuesto
             // gracias a la relación del modelo. Laravel le crea al presupuesto una línea que le pertenezca
             $presupuesto->lineasPresupuestos()->create([

             //Producto asociadoa la línea
             'producto_id' => $producto->id,

             //Precio del producto
             'precio' => $precio,

             //Cantidad
             'cantidad' =>$cantidad
             ]);

             //Ahora suma el subtotal al total acumulado
             $total += $subtotal;
            }

            //Por último se actualiza el total del presupuesto
            $presupuesto->update(['total' =>$total]);
        });

    }
}
