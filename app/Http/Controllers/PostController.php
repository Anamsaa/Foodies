<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Photo;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'imagen-post-regular' => 'nullable|image|max:2048',
            'texto-publicacion-post' => 'nullable|string|max:1000',
        ]);

        if (Auth::guard('restaurant')->check()) {
            $profile = Auth::guard('restaurant')->user()->profile;
        } elseif (Auth::guard('user')->check()) {
            $profile = Auth::guard('user')->user()->profile;
        } else {
            return back()->withErrors(['error' => 'No se pudo identificar el usuario autenticado.']);
        }

        if (!$profile) {
            return back()->withErrors(['error' => 'Perfil no encontrado']);
        }

        $photoId = null; 
        if ($request->hasFile('imagen-post-regular')) {
            $path = $request->file('imagen-post-regular')->store('posts', 'public'); 
            $photo = Photo::create(['url' => $path]);
            $photoId = $photo->id; 
        }

        Post::create([
            'profile_id' => $profile->id, 
            'status' => 'Published', 
            'visibility' => 'Public',
            'photo_id' => $photoId, 
            'content' => $request->input('texto-publicacion-post'), 
            'post_type' => 'Normal',
        ]);

        return $this->redireccionarDashboard();  
    }

        public function edit(Post $post) {
            if ($post->type === 'Culinary Event' && $post->culinaryEvent) {
                return redirect()->route('evento.edit', $post->culinaryEvent);
            }

            $profile = $post->profile;

            if ($profile->user_type === 'Restaurant') {
                return view('publicaciones.form-posts-restaurant', compact('post'));
            }

            return view('publicaciones.form-posts', compact('post')); 
        }

    public function update(Request $request, Post $post) {
        $request->validate([
            'imagen-post-regular' => 'nullable|image|max:2048',
            'texto-publicacion-post' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('imagen-post-regular')) {
            $path = $request->file('imagen-post-regular')->store('posts', 'public'); 
            $photo = Photo::create(['url' => $path]);
            $post->photo_id = $photo->id;
        }
        
        $post->content = $request->input('texto-publicacion-post');
        $post->save();

        return $this->redireccionarDashboard();  
    }

    public function destroy(Post $post){
        $perfil = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile;

        if (!$perfil || $post->profile_id !== $perfil->id) {
        return redirect()->back()->withErrors('No tienes permisos para eliminar esta publicación.');
        }
        $post->delete();

        return redirect()->back()->with('success', 'Publicación eliminada correctamente.');
    }

    // Redirigir a los usuarios según su rol
    public function redireccionarDashboard() {
        if (Auth::guard('restaurant')->check()) {
            return redirect()->route('dashboard.restaurant');
        } elseif (Auth::guard('user')->check()) {
            return redirect()->route('dashboard.user');
        }
        return redirect('/');
    }

    public function like(Post $post) {
        $profile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile;

        if (!$profile) {
        return response()->json(['error' => 'Perfil no encontrado.'], 403);
        }
        // Evitar duplicados
        if (!$post->likes()->where('profile_id', $profile->id)->exists()) {
        $post->likes()->create(['profile_id' => $profile->id]);
        }

        return response()->json(['likes_count' => $post->likes()->count()]);
    }

    public function unlike(Post $post) {
        $profile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile;

        if (!$profile) {
        return response()->json(['error' => 'Perfil no encontrado.'], 403);
        }

        $post->likes()->where('profile_id', $profile->id)->delete();

        return response()->json(['likes_count' => $post->likes()->count()]);
    }
}
