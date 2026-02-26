<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los productos de la base de datos

        $productos = Producto::all();

        // y los pasamos a la vista
        return view('admin.productos.index', compact('productos'));
        //Laravel separa directorios con puntos, esto es como admin/productos/index
        //Compact es un método que crea un array asociativo ['producto' => $producto] 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No necesita nada de la base de datos
        // Solo muestra el formulario vacío
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Primero validamos los datos que nos llegan del formulario
        // Si la validación falla, Laravel redirige automáticamente
        // de vuelta al formulario con los errores
        $request->validate([
            // 'tipo' es obligatorio y tiene que ser texto
            'tipo' => 'required|string|max:255',
            // 'precio_base' es obligatorio, tiene que ser un número y mayor que 0
            'precio_base' => 'required|numeric|min:0',
        ]);

        // Si la validación pasa, creamos el producto en la base de datos
        // con los datos que nos han mandado desde el formulario
        Producto::create([
            'tipo' => $request->tipo,
            'precio_base' => $request->precio_base,
        ]);

        // Redirigimos al listado de productos con un mensaje de éxito
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        // Laravel ya me trae el producto automáticamente
        // Solo tengo que pasárselo a la vista
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
