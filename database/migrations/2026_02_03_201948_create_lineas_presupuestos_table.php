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
        Schema::create('linea_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('presupuesto_id')->constrained()->cascadeOnDelete();//Me aseguro que si borro un presupuesto o un producto, las líneas se borran también.
            $table->foreignId('producto_id')->constrained()->cascadeOnDelete();
            $table->float('precio');
            $table->integer('cantidad');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_presupuestos');
    }
};
