<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class RegisterRestaurantController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all(), 'Antes de crear cuenta tipo restaurant');
        $request->validate([
            'email' => ['required', 
            'email', 'confirmed', 'unique:accounts,email'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&-_]).{8,}$/'],
        ],[
            'email.unique' => 'Este correo ya está registrado. Intenta con otro.',
            'email.confirmed' => 'Los correos electrónicos no coinciden.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial (@$!%*#?&-_)',
        ]);

        Account::create([
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'type' => 'restaurant',
        ]);

        return redirect()->route('login.restaurant')->with('success', 'Registro exitoso. Ahora puedes Iniciar Sesión');
    }
}
