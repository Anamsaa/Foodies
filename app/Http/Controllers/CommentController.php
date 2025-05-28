<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Profile;
use App\Models\Restaurant;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function showCommentsForUser(Post $post) {
        return view('personas.comentarios', ['post' => $post]);
    }

    public function showCommentsForRestaurant(Post $post) {
        return view('restaurantes.comentarios', ['post' => $post]);
    }

    public function createComment(Request $request, Post $post){
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $profile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile; 

        if(!$profile) {
            return back()->withErrors(['error' => 'No autorizado']); 
        }

        $post->comments()->create([
            'profile_id' => $profile->id,
            'content' => $request->input('content')
        ]); 

        if (auth('restaurant')->check()) {
            return redirect()->route('dashboard.restaurant', $post)->with('highlight_post', $post->id);
        }

        return redirect()->route('dashboard.user')->with('highlight_post', $post->id);;
    }

    public function deleteComment(Comment $comment) {
         $profile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile; 

         if(!$profile || $profile->id !== $comment->profile_id) {
            return back()->withErrors(['error' => 'No puedes eliminar este comentario.']);
         }

         $comment->delete();

         return redirect()->back();
    }
}
