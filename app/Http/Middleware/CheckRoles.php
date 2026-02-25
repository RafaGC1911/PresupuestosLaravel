<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    /**git
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        /**
         * Con esto obtenemos el usuario autenticado actualmente desde la sesión.
         *  Si no hay nadie logueado, $user será null.
         */
        $user = $request->user();

        //Si no está autenticado lo redirijo a la página de login.
        if(!$user){
            return redirect()->route('login');
        }

    //  Compuebo si el rol del usuario autenticado coincide con el rol
    //  que se ha pasado como parámetro al middleware.
    //  Por ejemplo, si la ruta tiene ->middleware('rol:admin') entonces
    //  $rol será admin.
    //  Si el rol del usuario no coincide, lanza un error 403
    //  que significa que el usuario está autenticado pero no tiene permisos
    //  para acceder a esta página.
     
        if($user->rol !== $rol){
            abort(403, "No tienes permiso para estar en esta sección");
        }
        //Si llega aquí significa que todo está bien
        return $next($request);
    }
}
