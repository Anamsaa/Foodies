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

        // if (!$restaurant) {
        //     return back()->withErrors(['email' => 'Esta cuenta no está registrada como restaurante.']);
        // }

        if (!Hash::check($request->password, $user->password_hash)) {
             return back()->withErrors(['password' => 'Contraseña incorrecta.']);
        }

        Auth::guard('user')->login($user);
        //Usuario Persona - prueba 
        //hola@prueba.test
        //12345678

        $request->session()->regenerate();


        return redirect()->route('dashboard.user');
    }
}