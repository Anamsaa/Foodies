<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutPeopleController extends Controller
{
    public function logout(Request $request) {

        Auth::guard('user')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirección al login del restaurante 
        return redirect()->route('login.user');

    }
}
