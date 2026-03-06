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

    //index muestra todos los productos
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
    //create  muestra el formulario vacío. No hace nada con la base de datos.
    public function create()
    {
        // No necesita nada de la base de datos
        // Solo muestra el formulario vacío
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    //store recibe los datos del formulario cuando le das a "Guardar", los valida y los guarda en la base de datos.
    public function store(Request $request)
    {
        // Primero validamos los datos que nos llegan del formulario
        // Si la validación falla, Laravel redirige automáticamente
        // de vuelta al formulario con los errores

        /* Request es un objeto que representa la petición HTTP que llega al servidor cuando el usuario hace algo — 
        en este caso cuando rellena el formulario y le da a "Guardar".
        Es una caja que contiene todo lo que el usuario ha enviado. 
        Por ejemplo cuando rellenas el formulario de crear producto y le das a guardar*/
        //validate comprueba que todo lo que ha llegado del usuario al request cumpla estas reglas:
        $request->validate([
            // 'tipo' es obligatorio y tiene que ser texto
            'tipo' => 'required|string|max:255', //tipo contiene lo que el usuario escribió en el campo "tipo" del formulario
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
        /**
         * En lugar de devolver una vista como hacemos en index o show con return view(...), aquí le decimos a Laravel que haga una redirección — es decir, 
         * que mande al usuario a otra página automáticamente.
         *  Esto es lo normal después de guardar datos, para evitar que si el usuario recarga la página se vuelvan a enviar los datos del formulario.
         */
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado'); //Esto añade un mensaje flash a la sesión. Un mensaje flash es un mensaje temporal que solo existe durante la siguiente petición — es decir, solo se muestra una vez y luego desaparece.
        //'success' es el nombre que le damos al mensaje, y 'Producto actualizado correctamente' es el texto del mensaje.
    }

    /**
     * Display the specified resource.
     */
    //show muestra un solo producto
    public function show(Producto $producto)
    {
        // Laravel ya me trae el producto automáticamente
        // Solo tengo que pasárselo a la vista
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    //Edit muestra el formulario pero con los datos del producto ya rellenados.
    public function edit(Producto $producto)
    {
        // Laravel ya nos trae el producto gracias al Route Model Binding
        // Solo lo pasamos a la vista para rellenar el formulario con sus datos
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    //	update recibe los datos modificados, los valida y los guarda en la base de datos.
    public function update(Request $request, Producto $producto)
    {
        // Validamos igual que en store
        $request->validate([
            'tipo' => 'required|string|max:255',
            'precio_base' => 'required|numeric|min:0',
        ]);

        // En lugar de crear uno nuevo, actualizamos el que ya existe
        $producto->update([
            'tipo' => $request->tipo,
            'precio_base' => $request->precio_base,
        ]);

        // Redirigimos al listado con mensaje de éxito
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
    // Borramos el producto de la base de datos
    $producto->delete();

    // Redirigimos al listado con mensaje de confirmación
    return redirect()->route('admin.productos.index')
        ->with('success', 'Producto eliminado correctamente');
    }
}
