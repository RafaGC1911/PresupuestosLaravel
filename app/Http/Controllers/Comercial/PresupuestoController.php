<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; //Importar la clase que permite usar la librería para generar pdf

class PresupuestoController extends Controller
{
   public function index(Request $request)
{
    // Empezamos construyendo la consulta base filtrando siempre por el comercial logueado.
    // Auth::id() devuelve el ID del usuario de la sesión actual.
    // Si no filtráramos por user_id, todos los comerciales verían los presupuestos de los demás.
    // Usamos query() en lugar de get() directamente porque queremos añadir filtros opcionales después.
    $query = Presupuesto::where('user_id', Auth::id())
        // with(['cliente']) significa "cuando traigas los presupuestos,
        // trae también los datos del cliente asociado a cada uno en la misma consulta".
        // Sin esto, Laravel haría una consulta extra a la base de datos por cada presupuesto
        // para obtener el nombre del cliente, lo cual es muy ineficiente.
        ->with(['cliente']);

    // Comprobamos si el usuario ha escrito algo en el buscador de cliente.
    // $request->filled() devuelve true si el campo existe y no está vacío.
    if ($request->filled('cliente')) {
        // whereHas filtra los presupuestos que tengan un cliente que cumpla la condición.
        // Es decir, busca presupuestos cuyo cliente tenga ese nombre.
        $query->whereHas('cliente', function($q) use ($request) {
            // LIKE %texto% busca que el nombre contenga el texto en cualquier posición.
            // Por ejemplo si buscas "gar" encontrará "García", "Garriga", etc.
            $q->where('nombre', 'like', '%' . $request->cliente . '%');
        });
    }

    // Comprobamos si el usuario ha seleccionado un estado en el desplegable.
    if ($request->filled('estado')) {
        // Filtramos los presupuestos que tengan exactamente ese estado.
        $query->where('estado', $request->estado);
    }

    // Ejecutamos la consulta con todos los filtros aplicados y obtenemos los resultados.
    // Si no se ha aplicado ningún filtro, devuelve todos los presupuestos del comercial.
    $presupuestos = $query->get();

    return view('comercial.presupuestos.index', compact('presupuestos'));
}

    public function create()
    {
        // Necesitamos traer todos los clientes y productos de la base de datos
        // para poder mostrarlos en los selectores desplegables del formulario.
        $clientes = Cliente::all();
        $productos = Producto::all();

        return view('comercial.presupuestos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        // Validamos todos los datos que llegan del formulario antes de hacer nada.
        $request->validate([
            // exists:clientes,id significa que el cliente_id que llega tiene que existir
            // como id en la tabla clientes. Evita que alguien envíe un ID inventado.
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            // El estado solo puede ser uno de estos tres valores.
            'estado' => 'required|in:pendiente,aceptado,rechazado',
            // Validamos que el array de líneas exista y tenga al menos una línea.
            // porque sin al menos una línea no tiene sentido crear un presupuesto.
            'lineas' => 'required|array|min:1',
            // El asterisco * significa "para cada elemento del array lineas".
            // Es decir cada línea tiene que tener un producto_id que exista en la tabla productos.
            'lineas.*.producto_id' => 'required|exists:productos,id',
            // Cada línea tiene que tener una cantidad que sea un número entero mayor que 0.
            'lineas.*.cantidad' => 'required|integer|min:1',
        ]);

        // Creamos el presupuesto en la base de datos con total 0 de momento.
        // El total lo calcularemos después cuando procesemos las líneas.
        // Auth::id() devuelve el ID del comercial que está logueado,
        // así el presupuesto queda asociado automáticamente a quien lo está creando.
        $presupuesto = Presupuesto::create([
            'cliente_id' => $request->cliente_id,
            'user_id' => Auth::id(),
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'total' => 0,
        ]);

        // Esta variable irá acumulando el total a medida que procesemos cada línea.
        $total = 0;

        // Recorremos cada línea que ha enviado el formulario.
        // $request->lineas es un array con todos los productos y cantidades que ha añadido el comercial.
        foreach ($request->lineas as $linea) {
            // Buscamos el producto en la base de datos por su ID
            // para obtener su precio base actual.
            $producto = Producto::find($linea['producto_id']);

            // Calculamos el subtotal de esta línea multiplicando precio por cantidad.
            $subtotal = $producto->precio_base * $linea['cantidad'];

            // Creamos la línea asociada al presupuesto.
            // lineasPresupuestos() es la relación hasMany del modelo Presupuesto.
            // Al llamarla así, Laravel asocia automáticamente la línea al presupuesto actual
            // sin que tengamos que poner el presupuesto_id manualmente.
            $presupuesto->lineasPresupuestos()->create([
                'producto_id' => $producto->id,
                // Guardamos el precio en el momento de crear el presupuesto.
                // Así si el precio del producto cambia en el futuro,
                // el presupuesto conserva el precio original.
                'precio' => $producto->precio_base,
                'cantidad' => $linea['cantidad'],
            ]);

            // Sumamos el subtotal de esta línea al total acumulado.
            $total += $subtotal;
        }

        // Ahora que tenemos el total real calculado, actualizamos el presupuesto.
        // Lo hacíamos en 0 antes porque necesitábamos procesar las líneas primero.
        $presupuesto->update(['total' => $total]);

        return redirect()->route('comercial.presupuestos.index')
            ->with('exito', 'Presupuesto creado correctamente');
    }

    public function show(Presupuesto $presupuesto)
    {
        // load() funciona igual que with() pero sobre un modelo que ya tenemos cargado.
        // Le decimos que cargue el cliente, las líneas del presupuesto
        // y el producto de cada línea — todo en una sola llamada.
        // El punto en 'lineasPresupuestos.producto' significa
        // "carga las líneas Y dentro de cada línea carga también su producto".
        $presupuesto->load(['cliente', 'lineasPresupuestos.producto']);

        return view('comercial.presupuestos.show', compact('presupuesto'));
    }

    public function edit(Presupuesto $presupuesto)
    {
        // Necesitamos clientes y productos para los selectores del formulario,
        // igual que en create.
        $clientes = Cliente::all();
        $productos = Producto::all();

        // Cargamos las líneas actuales del presupuesto junto con su producto
        // para poder mostrarlas ya rellenas en el formulario de edición.
        $presupuesto->load('lineasPresupuestos.producto');

        return view('comercial.presupuestos.edit', compact('presupuesto', 'clientes', 'productos'));
    }

    public function update(Request $request, Presupuesto $presupuesto)
    {
        // Mismas validaciones que en store.
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'estado' => 'required|in:pendiente,aceptado,rechazado',
            'lineas' => 'required|array|min:1',
            'lineas.*.producto_id' => 'required|exists:productos,id',
            'lineas.*.cantidad' => 'required|integer|min:1',
        ]);

        // Actualizamos los datos principales del presupuesto.
        // Ponemos el total a 0 porque lo vamos a recalcular con las nuevas líneas.
        $presupuesto->update([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'total' => 0,
        ]);

        // Borramos todas las líneas antiguas del presupuesto.
        // Es más simple que comparar cuáles han cambiado y cuáles no.
        // Las líneas nuevas las crearemos a continuación desde cero.
        // Esto funciona porque en la migración pusimos cascadeOnDelete,
        // pero aquí lo hacemos manualmente porque es un update, no un delete del presupuesto.
        $presupuesto->lineasPresupuestos()->delete();

        $total = 0;

        // Mismo proceso que en store. recorremos las nuevas líneas,
        // las creamos y acumulamos el total.
        foreach ($request->lineas as $linea) {
            $producto = Producto::find($linea['producto_id']);
            $subtotal = $producto->precio_base * $linea['cantidad'];

            $presupuesto->lineasPresupuestos()->create([
                'producto_id' => $producto->id,
                'precio' => $producto->precio_base,
                'cantidad' => $linea['cantidad'],
            ]);

            $total += $subtotal;
        }

        // Actualizamos el total con el valor recalculado.
        $presupuesto->update(['total' => $total]);

        return redirect()->route('comercial.presupuestos.index')
            ->with('exito', 'Presupuesto actualizado correctamente');
    }

    public function destroy(Presupuesto $presupuesto)
    {
        // Borramos el presupuesto.
        // Las líneas se borran automáticamente gracias al cascadeOnDelete
        // que definimos en la migración de linea_presupuestos.
        // Es decir, no tenemos que borrar las líneas manualmente.
        $presupuesto->delete();

        return redirect()->route('comercial.presupuestos.index')
            ->with('exito', 'Presupuesto eliminado correctamente');
    }

    //Método para generar un pdf de un presupuesto
    public function pdf(Presupuesto $presupuesto)
{
    // Cargar relaciones necesarias para tener todos los datos
    $presupuesto->load(['cliente', 'lineasPresupuestos.producto']);

    // Coge una vista de blade y la convierte en pdf
    $pdf = Pdf::loadView('comercial.presupuestos.pdf', compact('presupuesto'));

    // Esto fuerza la descarga del archivo
    return $pdf->download('presupuesto_'.$presupuesto->id.'.pdf');
}
}