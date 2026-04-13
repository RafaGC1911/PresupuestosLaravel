<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
/**
 * significa: "ve a App/Http/Controllers/Admin/ProductoController.php —
 *  que es el archivo que se ha generado con el comando artisan para el controlador de producto y 
 * llámalo AdminProductoController para usarlo en este archivo".
 */

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Comercial\PresupuestoController as ComercialPresupuestoController;

//Aquí en web.php se definen las rutas, se definen qué URL ejecuta qué controlador

Route::get('/', function () {
    //Apuntar directamente a auth.login para que al iniciar la app no se vaya a la página de publicidad de laravel
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class,'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas del panel de administración
//
// Solo accesibles si estás logueado, verificado y tienes rol admin
Route::middleware(['auth', 'verified', 'rol:admin'])
    ->prefix('admin')        // prefix es un método para que en la url salga admin
    ->name('admin.')         // con ->name los nombres de ruta empezarán por admin
    ->group(function () {
        //  Route::resource es simplemente un atajo para no tener que escribir las 7 rutas básicas a mano.
        // Y como estamos dentro del grupo con prefix('admin') y name('admin.'), Laravel añade automáticamente el prefijo y el nombre a todas ellas.
        Route::resource('productos', AdminProductoController::class);
        Route::resource('users', AdminUserController::class);//Esta línea le dice a Laravel que cree automáticamente las 7 rutas estándar para el recurso users, todas apuntando al AdminUserController
    });

// Rutas del área comercial
// Solo accesibles si estás logueado, verificado y tienes rol comercial
Route::middleware(['auth', 'verified', 'rol:comercial'])
    ->prefix('comercial')
    ->name('comercial.')
    ->group(function () {
        Route::resource('presupuestos', ComercialPresupuestoController::class);
    });


//Ruta para conectar la url con la función del presupuestoController para crear pdfs
Route::get('presupuestos/{presupuesto}/pdf', [ComercialPresupuestoController::class, 'pdf'])
    ->name('comercial.presupuestos.pdf');
require __DIR__.'/auth.php';
