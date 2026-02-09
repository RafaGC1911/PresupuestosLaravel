<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lineas_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('presupuesto_id');
            $table->foreignId('producto_id');
            $table->float('precio');
            $table->integer('cantidad');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas_presupuestos');
    }
};
