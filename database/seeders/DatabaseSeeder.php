<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

    //Crea un usuario con rol admin para desde este dar de alta luego a los demás usuarios
        User::factory()->create([

            'name' => 'admin',
            'email' => 'admin@proyecto.com',
            //Por defecto crea admin y contraseña admin
            'rol' => 'admin',
            'password' => Hash::make('admin')
        ]);

        //Ahora llama a los seeders creados:
        $this->call([
        ClienteSeeder::class, //Crea clientes 
        ProductoSeeder::class, //Crea productos
        PresupuestoSeeder::class, //Crea presupuestos
        LineasPresupuestoSeeder::class, // Crea líneas de presupuesto
    ]);
        
    }
}
