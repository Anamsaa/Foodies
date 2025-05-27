<?php

namespace App\Http\Controllers;

use App\Models\CulinaryEvent;
use App\Models\EventParticipation;
use App\Models\Post;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CulinaryEventController extends Controller
{
    public function create(){
        $profile = Auth::guard('user')->user()->profile;

        // Restaurantes cuyo perfil esté en la misma provincia
        $restaurantesLocales = Restaurant::whereHas('profile', function ($query) use ($profile) {
            $query->where('province_id', $profile->province_id);
        })->get();

        return view('personas.formulario-evento', compact('restaurantesLocales'));
    }

    public function store(Request $request){
        $request->validate([
            'experience-title' => 'required|string|max:100',
            'restaurant-option' => 'required|exists:restaurants,id',
            'invitacion' => 'required|string|max:1000',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'required|date_format:H:i',
            'max_participants' => 'required|integer|min:1|max:100',
        ]);

        $profile = Auth::guard('user')->user()->profile;


        // Crear el post
        $post = $profile->posts()->create([
            'type' => 'evento_culinario',
            'content' => $request->input('invitacion'),
        ]);

        // Crear el evento culinario
        CulinaryEvent::create([
            'post_id' => $post->id,
            'title' => $request->input('experience-title'),
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time'),
            'status' => 'Ongoing',
            'max_participants' => $request->input('max_participants'),
            'short_description' => Str::limit($request->input('invitacion'), 120),
            'restaurant_id' => $request->input('restaurant-option'),
        ]);

        return redirect()->route('dashboard.user')->with('success', 'Evento creado exitosamente.');
    }

  
    public function join(CulinaryEvent $event){
        $profile = Auth::guard('user')->user()->profile;
        $person = $profile->person;

        if (!$person) {
            return back()->withErrors('Solo los usuarios tipo Persona pueden participar.');
        }

        if ($event->participations()->where('person_id', $person->id)->exists()) {
            return back()->withErrors('Ya estás inscrito en este evento.');
        }

        if ($event->participations()->count() >= $event->max_participants) {
            return back()->withErrors('Este evento ya está completo.');
        }

        $event->participations()->create([
            'person_id' => $person->id,
            'registration_date' => now(),
            'status' => 'confirmado',
        ]);
        return back()->with('success', 'Te has unido al evento.');
    }


    public function leave(CulinaryEvent $event){
        $profile = Auth::guard('user')->user()->profile;
        $person = $profile->person;

        $participation = $event->participations()->where('person_id', $person->id)->first();
        if (!$participation) {
            return back()->withErrors('No estás inscrito en este evento.');
        }
        $participation->delete();
        return back()->with('success', 'Has cancelado tu participación.');
    }

    public function edit(CulinaryEvent $event){

        $this->authorizeOwner($event); 
        $profile = auth('user')->user()->profile;
        $restaurantesLocales = Restaurant::whereHas('profile', fn($q) =>
            $q->where('province_id', $profile->province_id)
        )->get();
        return view('personas.editar-evento', compact('event', 'restaurantesLocales'));

    }

    // Guardar cambios
    public function update(Request $request, CulinaryEvent $event){
        $this->authorizeOwner($event);

        $request->validate([
            'experience-title' => 'required|string|max:100',
            'restaurant-option' => 'required|exists:restaurants,id',
            'invitacion' => 'required|string|max:1000',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'required|date_format:H:i',
            'max_participants' => 'required|integer|min:1|max:100',
        ]);

        $event->post->update([
            'content' => $request->input('invitacion'),
        ]);

        $event->update([
            'title' => $request->input('experience-title'),
            'event_date' => $request->input('event_date'),
            'event_time' => $request->input('event_time'),
            'restaurant_id' => $request->input('restaurant-option'),
            'max_participants' => $request->input('max_participants'),
            'short_description' => Str::limit($request->input('invitacion'), 120),
        ]);

        return redirect()->route('dashboard.user')->with('success', 'Evento actualizado.');
    }

    // Eliminar evento y su post
    public function destroy(CulinaryEvent $event){
        $this->authorizeOwner($event);

        $event->post->delete(); // Cascada elimina el evento también
        return redirect()->route('dashboard.user')->with('success', 'Evento eliminado.');
    }

    // Método privado para verificar propiedad
    private function authorizeOwner(CulinaryEvent $event){
        $currentProfileId = auth('user')->user()->profile->id;
        if ($event->post->profile_id !== $currentProfileId) {
            abort(403, 'No tienes permiso para modificar este evento.');
        }
    }
}
