<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // index muestra todos los productos
    public function index()
    {
        // Traemos todos los productos de la base de datos
        $productos = Producto::all();

        // Los pasamos a la vista
        // Laravel separa directorios con puntos, esto es como admin/productos/index
        // compact() crea un array asociativo ['productos' => $productos]
        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */

    // create muestra el formulario vacío. No hace nada con la base de datos.
    public function create()
    {
        // No necesita nada de la base de datos
        // Solo muestra el formulario vacío
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    // store recibe los datos del formulario cuando le das a "Guardar", los valida y los guarda en la base de datos.
    public function store(Request $request)
    {
        // Primero validamos los datos que nos llegan del formulario.
        // Si la validación falla, Laravel redirige automáticamente
        // de vuelta al formulario con los errores.
        $request->validate([
            // 'tipo' es obligatorio y tiene que ser texto
            'tipo' => 'required|string|max:255',
            // 'precio_base' es obligatorio, tiene que ser un número y mayor que 0
            'precio_base' => 'required|numeric|min:0',
            // 'imagen' es opcional — nullable significa que puede venir vacía
            // image significa que tiene que ser una imagen
            // mimes limita los formatos permitidos
            // max:2048 limita el tamaño a 2MB (2048 kilobytes)
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Variable donde guardaremos la ruta de la imagen
        // La inicializamos como null por si no se sube ninguna imagen
        $rutaImagen = null;

        // Comprobamos si el usuario ha subido una imagen
        // $request->hasFile() devuelve true si el campo tiene un archivo adjunto
        if ($request->hasFile('imagen')) {
            // Guardamos la imagen en storage/app/public/productos/
            // store() genera automáticamente un nombre único para el archivo
            // para evitar que dos imágenes con el mismo nombre se sobreescriban
            // 'public' indica que se guarda en la carpeta pública accesible desde el navegador
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        // Creamos el producto en la base de datos con todos sus datos
        Producto::create([
            'tipo' => $request->tipo,
            'precio_base' => $request->precio_base,
            // Si no se subió imagen, imagen quedará como null en la base de datos
            'imagen' => $rutaImagen,
        ]);

        // Redirigimos al listado de productos con un mensaje flash de éxito
        // El mensaje flash solo existe durante la siguiente petición y luego desaparece
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    /**
     * Display the specified resource.
     */

    // show muestra un solo producto
    public function show(Producto $producto)
    {
        // Laravel ya nos trae el producto automáticamente gracias al Route Model Binding
        // Solo tenemos que pasárselo a la vista
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */

    // edit muestra el formulario con los datos del producto ya rellenados
    public function edit(Producto $producto)
    {
        // Laravel ya nos trae el producto gracias al Route Model Binding
        // Solo lo pasamos a la vista para rellenar el formulario con sus datos
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */

    // update recibe los datos modificados, los valida y los guarda en la base de datos
    public function update(Request $request, Producto $producto)
    {
        // Validamos igual que en store
        $request->validate([
            'tipo' => 'required|string|max:255',
            'precio_base' => 'required|numeric|min:0',
            // La imagen es opcional al editar — el producto puede mantener la imagen anterior
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Variable para guardar la ruta de la nueva imagen
        // Por defecto mantenemos la imagen actual del producto
        $rutaImagen = $producto->imagen;

        // Comprobamos si el usuario ha subido una imagen nueva
        if ($request->hasFile('imagen')) {
            // Si el producto ya tenía una imagen anterior la borramos del almacenamiento
            // para no dejar archivos huérfanos ocupando espacio
            if ($producto->imagen) {
                // Storage::disk('public')->delete() borra el archivo del disco
                Storage::disk('public')->delete($producto->imagen);
            }

            // Guardamos la nueva imagen y actualizamos la ruta
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        // Actualizamos el producto con los nuevos datos
        $producto->update([
            'tipo' => $request->tipo,
            'precio_base' => $request->precio_base,
            // Guardamos la ruta de la imagen — puede ser la nueva o la anterior
            'imagen' => $rutaImagen,
        ]);

        // Redirigimos al listado con mensaje de éxito
        return redirect()->route('admin.productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */

    // destroy borra el producto de la base de datos
 public function destroy(Producto $producto)
{
    // Comprobamos si el producto está siendo usado en alguna línea de presupuesto
    // lineasPresupuestos() es la relación hasMany que definimos en el modelo Producto
    // exists() devuelve true si hay al menos una línea que use este producto
    if ($producto->lineasPresupuestos()->exists()) {
        // Si está siendo usado no lo borramos y redirigimos con un mensaje de error
        // No podemos borrarlo porque dejaríamos presupuestos sin coherencia
        return redirect()->route('admin.productos.index')
            ->with('error', 'No se puede eliminar el producto porque está siendo usado en uno o más presupuestos');
    }

    // Si el producto tiene una imagen la borramos del almacenamiento antes de borrar el producto
    // Así no dejamos archivos huérfanos en el servidor
    if ($producto->imagen) {
        Storage::disk('public')->delete($producto->imagen);
    }

    // Si no está siendo usado en ningún presupuesto lo borramos sin problema
    $producto->delete();

    return redirect()->route('admin.productos.index')
        ->with('success', 'Producto eliminado correctamente');
}
}