<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;



class DashboardController extends Controller
{
    public function index(Request $request): View|RedirectResponse{
$user = $request->user();

if($user->isAdmin()){
    return view('admin.dashboard');
}

if($user->isComercial()){
    return view('comercial.dashboard');
}
    }
    

}
