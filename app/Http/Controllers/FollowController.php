<?php

namespace App\Http\Controllers;
use App\Models\Profile;
use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request, Profile $profile){
        $follower = Auth::guard('user')->user()?->profile;

        if (!$follower || $follower->user_type !== 'Person') {
            return response()->json(['error' => 'No autorizado para seguir.'], 403);
        }

        if ($follower->id === $profile->id) {
            return response()->json(['error' => 'No puedes seguirte a ti mismo.'], 400);
        }

        $alreadyFollowing = Follow::where('follower_id', $follower->id)
            ->where('followed_id', $profile->id)
            ->first();

        if ($alreadyFollowing) {
            return response()->json(['message' => 'Ya sigues a este perfil.'], 200);
        }

        Follow::create([
            'follower_id' => $follower->id,
            'followed_id' => $profile->id,
            'status' => 'Following',
        ]);
        return response()->json(['message' => 'Seguido correctamente.']);
    }

    public function unfollow(Request $request, Profile $profile){
        $follower = Auth::guard('user')->user()?->profile;

        if (!$follower) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        Follow::where('follower_id', $follower->id)
            ->where('followed_id', $profile->id)
            ->delete();

        return response()->json(['message' => 'Dejaste de seguir.']);
    }

    public function sugerenciasParaSeguir(Request $request){
        $perfil = auth('user')->user()->profile;

        // Seguir personas que sean de la misma provincia
        $personQuery = Profile::with('person', 'profilePhoto')
            ->where('id', '!=', $perfil->id)
            ->where('province_id', $perfil->province_id)
            ->where('user_type', 'Person') 
            ->whereDoesntHave('followers', function ($q) use ($perfil) {
                $q->where('follower_id', $perfil->id);
            });

        $restaurantQuery = Profile::with('restaurant', 'profilePhoto')
            ->where('id', '!=', $perfil->id)
            ->where('province_id', $perfil->province_id)
            ->where('user_type', 'Restaurant') 
            ->whereDoesntHave('followers', function ($q) use ($perfil) {
                $q->where('follower_id', $perfil->id);
            });


        // Condicional para filtrar personas sugeridas por nombre 
        if ($request->filled('search')) {
            $search = $request->search;
            $personQuery->whereHas('person', function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%");
            });

            $restaurantQuery->whereHas('restaurant', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%");
            });
        }

        $sugerenciasPersonas = $personQuery->get();
        $sugerenciasRestaurantes = $restaurantQuery->get();

        return view('personas.red', compact('sugerenciasPersonas', 'sugerenciasRestaurantes'));
    }

    public function verSeguidos(Request $request){

        $perfil = auth('user')->user()->profile;

        $query = $perfil->followings()->with(['followed.person', 'followed.restaurant', 'followed.profilePhoto']);

        // Filtro por búsqueda los seguidos de cada usuario
        if ($request->filled('search')) {
            $query->whereHas('followed', function ($q) use ($request) {
                $q->whereHas('person', function ($p) use ($request) {
                    $p->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%');
                })->orWhereHas('restaurant', function ($r) use ($request) {
                    $r->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Obtener seguidos filtrados (Collección de perfiles)
        $seguidos = $query->get()->pluck('followed');

        // Número total de seguidos del perfil autenticado (Devuelve un integer)
        $numeroSeguidos = $perfil->followings()->count();

        return view('personas.seguidos', compact('seguidos', 'numeroSeguidos'));
    }
}
