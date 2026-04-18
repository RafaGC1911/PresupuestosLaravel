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
        //Schema table en lugar de create para añadir una columna nueva llamada imagen a la tabla productos
        Schema::table('productos', function (Blueprint $table) {
            // Nullable porque los productos existentes no tienen imagen, after precio base es para que la columna aparezca después de la de precio base
            $table->string('imagen')->nullable()->after('precio_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('imagen');
        });
    }
};
