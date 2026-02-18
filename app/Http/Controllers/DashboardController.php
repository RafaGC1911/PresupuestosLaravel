<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;



class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return view('admin.dashboard');
        }

        if ($user->isComercial()) {
            return view('comercial.dashboard');
        }


        //Si no tiene rol válido, cierra la sesión y redirige al login
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('error', 'Rol de usuario no válido');
    }
}
