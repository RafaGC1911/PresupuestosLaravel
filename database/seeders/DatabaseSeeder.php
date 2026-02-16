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

    //Crea un usuario
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@proyecto.com',
            //Por defecto crea admin y contraseña admin
            'rol' => 'admin',
            'password' => Hash::make('admin')
        ]);

        //Ahora llama a los seeders creados:
        
        
    }
}
