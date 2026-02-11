<?php

namespace Database\Seeders;

use App\Models\LineaPresupuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class LineasPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LineaPresupuesto::factory(10)->create();
    }
}
