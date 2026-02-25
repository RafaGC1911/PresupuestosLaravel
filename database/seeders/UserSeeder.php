<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      //Usuario admin con nombre Admin y contraseña admin
       User::create([
        'name' => 'admin',
        'email' => 'admin@empresa.com',
        'password' => 'admin',
        'rol' => User::ROL_ADMIN
       ]);

       User::create([
        'name' => 'comercial',
        'email' => 'comercial@empresa.com',
        'password' => 'comercial',
        'rol' => User::ROL_COMERCIAL
       ]);
    }
}

