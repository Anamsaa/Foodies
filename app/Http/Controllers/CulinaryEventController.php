<?php

namespace App\Http\Controllers;

use App\Models\CulinaryEvent;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CulinaryEventController extends Controller
{
    public function create(){
        $profile = Auth::guard('user')->user()->profile;

        // Búsqueda de restaurantes por aquellos que estén en la misma provincia
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
            'post_type' => 'Culinary Event',
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
            $message = 'Solo los usuarios tipo Persona pueden participar.';
            return request()->ajax() 
                ? response()->json(['error' => $message], 403)
                : back()->withErrors($message);
        }

        if ($event->post->profile_id === $profile->id) {
            $message = 'No puedes unirte a tu propio evento.';
            return request()->ajax()
                ? response()->json(['error' => $message], 403)
                : back()->withErrors($message);
        }

        if ($event->participations()->where('person_id', $person->id)->exists()) {
            $message = 'Ya estás inscrito en este evento.';
            return request()->ajax() 
                ? response()->json(['error' => $message], 409)
                : back()->withErrors($message);
        }

        if ($event->participations()->count() >= $event->max_participants) {
            $message = 'Este evento ya está completo.';
            return request()->ajax() 
                ? response()->json(['error' => $message], 400)
                : back()->withErrors($message);
        }

        $event->participations()->create([
            'person_id' => $person->id,
            'registration_date' => now(),
            'status' => 'Registered',
            ]);

            return request()->ajax()
                ? response()->json(['message' => 'Te has unido al evento.'])
                : back()->with('success', 'Te has unido al evento.');
    }

    public function leave(CulinaryEvent $event){
        $profile = Auth::guard('user')->user()->profile;
        $person = $profile->person;

        $participation = $event->participations()->where('person_id', $person->id)->first();

        if (!$participation) {
            $message = 'No estás inscrito en este evento.';
            return request()->ajax()
                ? response()->json(['error' => $message], 404)
                : back()->withErrors($message);
        }

        $participation->delete();

        return request()->ajax()
            ? response()->json(['message' => 'Has cancelado tu participación.'])
            : back()->with('success', 'Has cancelado tu participación.');
    }
    public function edit(CulinaryEvent $event){

        $this->authorizeOwner($event);

        $restaurantesLocales = Restaurant::whereHas('profile', function ($query) use ($event) {
            $query->where('province_id', $event->post->profile->province_id);
        })->get();

        return view('personas.formulario-evento', compact('event', 'restaurantesLocales'));
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

        $event->post->delete(); 
        return redirect()->route('dashboard.user')->with('success', 'Evento eliminado.');
    }

    // Método privado para verificar propiedad
    private function authorizeOwner(CulinaryEvent $event){
        $currentProfileId = auth('user')->user()->profile->id;
        if ($event->post->profile_id !== $currentProfileId) {
            abort(403, 'No tienes permiso para modificar este evento.');
        }
    }

    public function verificarEvento(Request $request)  {
        $fecha = $request->input('fecha');
        $hora = $request->input('hora');
        $restaurantId = $request->input('restaurante_id');

        $yaExiste = CulinaryEvent::where('event_date', $fecha)
        ->where('event_time', $hora)
        ->where('restaurant_id', $restaurantId)
        ->exists();

        return response()->json(['disponible' => !$yaExiste]);
    }

    public function indexUser(){
        $perfil = auth('user')->user()->profile;
        $persona = $perfil->person;

        // Eventos que creó el usuario
        $misEventos = CulinaryEvent::with('post.profile')
            ->whereHas('post', fn($query) => $query->where('profile_id', $perfil->id))
            ->get();

        // Eventos en los que está inscrito que el usuario no creó
        $eventosUnidos = CulinaryEvent::with('post.profile')
            ->whereHas('participations', fn($query) => $query->where('person_id', $persona->id))
            ->whereHas('post', fn($query) => $query->where('profile_id', '!=', $perfil->id))
            ->get();

        // Eventos de cada provincia
        $eventosDisponibles = CulinaryEvent::with(['post.profile', 'restaurant.profile.profilePhoto', 'participations'])
            ->where('event_date', '>=', now())
            ->whereHas('post.profile', fn($q) => $q->where('province_id', $perfil->province_id))
            ->whereDoesntHave('participations', fn($q) => $q->where('person_id', $persona->id))
            ->whereHas('post', fn($q) => $q->where('profile_id', '!=', $perfil->id))
            ->get();

        $eventosPropiosYUnidos = $misEventos->merge($eventosUnidos);

        return view('personas.eventos', [
            'misEventos' => $eventosPropiosYUnidos,
            'eventosDisponibles' => $eventosDisponibles,
        ]);
    }

    // Conocer participantes
    // public function saberParticipantes(CulinaryEvent $evento){
    //     $participantes = $evento->participations()
    //         ->with('person.profile')
    //         ->get()
    //         ->map(function ($participation) {
    //             $profile = $participation->person->profile;
    //             return [
    //                 'nombre' => $profile->person->first_name . ' ' . $profile->person->last_name,
    //                 'url' => get_profile_route($profile),
    //             ];
    //         });

    //     return response()->json($participantes);
    // }
}
