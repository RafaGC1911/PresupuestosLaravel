<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;//Importar para usar el hash de la contraseña

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Traer todos los usuarios de la bdd
        $users = User::all();

        //pasárselos a la vista users dentro del directorio admin
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // No necesita nada de la base de datos
        // Solo muestra el formulario vacío
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate comprueba que todo lo que ha llegado del usuario al request cumpla estas reglas:
         $request->validate([
            'name' => 'required|string|max:255',
            // El email tiene que ser único en la tabla users
            'email' => 'required|email|unique:users,email',
            // confirmed significa que tiene que existir un campo password_confirmation igual
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:admin,comercial',//Es una regla de validación de Laravel que significa que el valor tiene que ser exactamente uno de estos
        ]);

        //Si pasa la validación creamos usuario con los datos que vienen del request
         User::create([
            'name' => $request->name,
            'email' => $request->email,
            // Hasheamos la contraseña antes de guardarla
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        //Redirigir al index de usuarios y mandar mensaje de éxito 
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //Le pasa a la vista un solo usuario para verlo
         return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //le pasa al archivo edit de users el formulario con los datos que tiene el usuario en ese momento
         return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //Validar datos que vengan del request
        $request->validate([
            'name' => 'required|string|max:255',
            // ignore:{$user->id} significa que ignore el email del usuario actual
            // para no dar error de duplicado al guardar el mismo email
            'email' => 'required|email|unique:users,email,' . $user->id,
            // La contraseña es opcional al editar — nullable significa que puede venir vacía
            'password' => 'nullable|string|min:6|confirmed',
            'rol' => 'required|in:admin,comercial',
        ]);

        /**Una vez pasa la validación guardamos los datos en un array porque
         * primero guardamos en $datos solo los campos que siempre van a venir rellenos, y luego comprobamos si la contraseña viene o no
         * Si hago el update directamente y el admin deja la contraseña vacía se actualizaría el usuario con una contraseña vacía*/
        $datos = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
        ];

        // Solo actualizamos la contraseña si el admin ha escrito una nueva
        // Si el campo viene vacío, dejamos la contraseña antigua
        if ($request->filled('password')) {
            $datos['password'] = Hash::make($request->password);
        }

        //Hacemos un update del usuario con los nuevos datos
        $user->update($datos);

         return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
