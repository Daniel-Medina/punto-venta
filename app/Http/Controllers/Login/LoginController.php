<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function login(Request $request) {

        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt($credenciales)){
            $request->session()->regenerate();

            return redirect()->route('inicio');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);


    }

    public function cerrarSesion(Request $request) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect('/');
    }
}
