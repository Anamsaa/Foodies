<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class LoginPeopleController extends Controller
{
   public function login(Request $request)
    {
        //dd('entra al controlador');
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = Account::where('email', $request->email)
                             ->where('type', 'user')
                             ->first();

        if (!$user || $user->type !== 'user') {
            return redirect()->route('register.user')->with('error', 'Esta cuenta no pertenece a una persona o no está registrada.');
        }

        if (!Hash::check($request->password, $user->password_hash)) {
             return back()->withErrors(['password' => 'Contraseña incorrecta.']);
        }

        Auth::guard('user')->login($user);

        $request->session()->regenerate();

        // Se verifica al hacer el login si el usuario ha creado un perfil.
        if($user->profile){
            return redirect()->intended(route('dashboard.user'));
        }

        // En caso contrario se lo redirige a la siguiente ruta: 
        return redirect()->intended(route('crear-perfil.user'));
    }
}