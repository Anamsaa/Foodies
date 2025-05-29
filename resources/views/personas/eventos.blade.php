@extends('layouts.layout-menu-panel')
@section('title', 'Eventos')
@section('description', 'Reúnete con otros foodies creando un evento culinario.')
@section('content')

<div class="pagina-eventos-culinarios">
    <h2 class="titulo-pagina-eventos">Eventos culinarios</h2>

        <h3>Tus próximos eventos</h3>
        <div id="contenedor-mis-eventos" class="eventos-resumen">
            @if ($misEventos->isEmpty())
                <p class="mensaje-vacio">Aún no has creado ni te has unido a ningún evento.</p>
            @endif
            @foreach($misEventos as $evento)
                <div class="card-evento evento-card">
                    {{-- Imagen del restaurante --}}
                    <a href="{{ get_profile_route($evento->restaurant->profile) }}">
                        <img src="{{ optional($evento->restaurant->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Restaurante">
                    </a>
                    <p class="titulo-evento">{{ $evento->title }}</p>

                    {{-- Solo si el usuario es el creador --}}
                    @php
                        $esPropietario = $evento->post->profile_id === auth('user')->user()->profile->id;
                    @endphp

                    @if($esPropietario)
                        <div class="post-options">
                            <form action="{{ route('evento.destroy', $evento) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </div>
                    @else

                    {{-- Si no es el propietario, descartar --}}
                    @php
                        $eventoId = $evento->id ?? $evento->post_id;
                        $perfil = auth('user')->user()?->profile;
                        $persona = $perfil?->person;
                        $yaInscrito = $evento->participations->contains('person_id', $persona->id ?? null);
                    @endphp

                    <form method="POST" class="form-unirse-evento" data-event-id="{{ $eventoId }}" data-is-joined="{{ $yaInscrito ? 'true' : 'false' }}">
                        @csrf
                        <button type="button" class="btn-unirse">
                            {{ $yaInscrito ? 'Descartar' : 'Unirse' }}
                        </button>
                    </form>
                    @endif
                </div>
            @endforeach

            {{-- Botón de creación --}}
            <div class="card-creacion-evento">
                <a href="{{ route('evento.create') }}">Crear nuevo evento
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
        </div>

        {{-- Al unirse a cualquiera de los eventos aquí mostrados dinámicamente, se debería generar una tarjeta en el contenedor de arriba con el titulo y nombre --}}
        <h3>Encuentra eventos cerca de ti</h3>
        <div id="contenedor-eventos-disponibles" class="eventos-detallados">
            @if ($eventosDisponibles->isEmpty())
                <p class="mensaje-vacio">No hay eventos disponibles en tu provincia por el momento. ¡Vuelve pronto!</p>
            @endif
            @foreach($eventosDisponibles as $evento)
                <div class="evento-card card-info-eventos">
                    <div class="evento-imagen">
                        <a href="{{ get_profile_route($evento->restaurant->profile) }}">
                            <img src="{{ optional($evento->restaurant->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Restaurante">
                        </a>
                    </div>
                    <div class="evento-detalles">
                        <h3>{{ $evento->title }}</h3>
                        {{-- Pasar nombre del creador del evento --}}
                        @php
                            $creadorEvento = $evento->post->profile;
                        @endphp
                        <strong>Organizador:</strong><a class="link-creador" href=" {{ get_profile_route($creadorEvento) }}"><p>{{ $creadorEvento->person->first_name }} {{ $creadorEvento->person->last_name }}</p></a>
                        <strong>Cupos disponibles:</strong><p>{{ $evento->max_participants - $evento->participations->count() }}</p>
                        <strong>Fecha:</strong><p>{{ \Carbon\Carbon::parse($evento->event_date)->format('d - m - Y') }}</p>
                        <strong>Hora:</strong><p>{{ \Carbon\Carbon::parse($evento->event_time)->format('H:i') }}</p>
                        <strong>Locación:</strong><a class="link-restaurante-eventos" href=" {{ get_profile_route($evento->restaurant->profile) }}"><p>{{ $evento->restaurant->name }}</p></a>
                       
                        <p class="evento-descripcion">{{ $evento->short_description }}</p>

                        {{-- Botón de participación --}}
                        @php
                            $perfil = auth('user')->user()?->profile;
                            $persona = $perfil?->person;
                            $yaInscrito = $evento->participations->contains('person_id', $persona->id ?? null);
                            $cuposDisponibles = $evento->max_participants - $evento->participations->count();
                        @endphp
                       
                        @if ($persona && $evento->post->profile_id !== $perfil->id  && $cuposDisponibles > 0)
                            
                            <form method="POST" class="form-unirse-evento" data-event-id="{{ $evento->post_id}}" data-is-joined="{{ $yaInscrito ? 'true' : 'false' }}">
                                @csrf
                                <button type="button" class="btn-unirse">
                                    {{ $yaInscrito ? 'Descartar' : 'Unirse' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
</div>
   