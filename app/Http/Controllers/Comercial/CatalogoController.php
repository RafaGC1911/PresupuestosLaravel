<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index()
    {
        // Traemos todos los productos disponibles para mostrarlos en el catálogo
        // El comercial solo puede verlos, no editarlos
        $productos = Producto::all();

        return view('comercial.catalogo.index', compact('productos'));
    }
}