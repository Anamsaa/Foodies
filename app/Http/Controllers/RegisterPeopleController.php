<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class RegisterPeopleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'confirmed', 'unique:accounts,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ],[
            'email.unique' => 'Este correo ya está registrado. Intenta con otro.',
            'email.confirmed' => 'Los correos electrónicos no coinciden.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        Account::create([
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'type' => 'user',
        ]);

        //Usuario Persona - prueba 
        //hola@prueba.test
        //12345678

        return redirect()->route('login.user')->with('success', 'Registro exitoso. Ahora puedes Iniciar Sesión');
    }
}
