<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class LoginRestaurantController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $restaurant = Account::where('email', $request->email)
                             ->where('type', 'restaurant')
                             ->first();

        if (!$restaurant) {
            return back()->withErrors(['email' => 'Esta cuenta no está registrada como restaurante.']);
        }

        if (!Hash::check($request->password, $restaurant->password_hash)) {
             return back()->withErrors(['password' => 'Contraseña incorrecta.']);
        }

        Auth::login($restaurant);
        //Usuario Persona - prueba 
        //hola@prueba.test
        //12345678

        return redirect()->route('dashboard.restaurant');
    }
}
