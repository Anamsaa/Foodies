@extends('layouts.layout-principal')
@section('title', 'Principal')
@section('description', 'Únete a la comunidad de apasionados por la cocina. Comparte tus platos, sigue a otros foodies y vive la experiencia gastronómica online.')
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="principal-container">
    <div class="column-1">
        <div class="creador-post" id="creador-post">
            <a href="{{ get_profile_route($perfil) }}"><img  class="imagen-usuario" src="{{ optional($perfil->profilePhoto)->url ?? asset('images/default_image_profile.png') }} " alt="Imagen de perfil usuario"></a>
            <div class="post-writer-container">
                <div class="simulated-input" id="simulador-input" data-url="{{ route('redactar.post') }}">
                    Cuéntales a tus amigos que se te antoja comer hoy...
                </div>
                <div class="botones">
                        {{-- Próxima ampliación a reseñas --}}
                        {{-- <a href="{{ route('redactar.review') }}">Nueva reseña</a> --}}
                        <a href="{{ route('evento.create') }}">Nuevo evento</a>
                </div>
            </div>
        </div>
        <div id="post-usuarios" class="post-usuarios">
            @forelse($posts as $post)
            {{--@dd($post)--}}
                @if (session('highlight_post') == $post->id)
                    <div class="nuevo-comentario">Tu comentario fue publicado</div>
                @endif

                @if ($post->post_type === 'Culinary Event' && $post->culinaryEvent)
                    @include('components.posts.event', [
                        'post' => $post,
                        'evento' => $post->culinaryEvent
                    ])
                @else
                    @include('components.posts.post', ['post' => $post])
                @endif
            @empty
                <p class="no-post-message">No hay publicaciones todavía.</p>
            @endforelse
        </div>
    </div>
    <div class="column-2">
        <div class="novedades-container">
            <h2>Últimas Novedades</h2>
            <div id="contenedor-novedades" class="contenedor-novedades">
                @forelse($misNovedades as $novedad)
                    <div class="novedad-item">
                        <a href="{{ get_profile_route($novedad['profile']) }}"><img src="{{ $novedad['foto'] }}" alt="Avatar"></a>
                        <div class="novedad-info">
                            <a href="{{ get_profile_route($novedad['profile']) }}" style="text-decoration: none; color: black;"><strong>{{ $novedad['nombre'] }}</strong></a> ha empezado a seguirte
                            <p>{{ $novedad['tiempo'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="mensaje-vacio">Aún no tienes novedades.</p>
                @endforelse
            </div>
        </div>
        <div class="encontrar-amigos">
            <h2>Sigue a otros</h2>
            <div id="seguir-usuarios" class="seguir-usuarios">
                {{-- Aquí van recomendaciones de personas a las cuales seguir basados en aspectos de ubicación y seguidos--}}
                @forelse($sugerencias as $sugerencia)
                    @php
                        $isRestaurant = $sugerencia->user_type === 'Restaurant';

                        $perfilRoute = match (true) {
                            $isRestaurant && auth('user')->check() => route('restaurant.perfil.user', $sugerencia),
                            !$isRestaurant && auth('user')->check() => route('perfil.user.ajeno', $sugerencia),
                            $isRestaurant && auth('restaurant')->check() => route('perfil.ajeno.restaurante', $sugerencia),
                            !$isRestaurant && auth('restaurant')->check() => route('user.perfil.restaurante', $sugerencia),
                            default => route('landing'),
                        };

                        $yaSigo = $perfil->followings()->where('followed_id', $sugerencia->id)->exists();
                    @endphp

                    <div class="sugerencia-item">
                        <a href="{{ $perfilRoute }}">
                            <img src="{{ optional($sugerencia->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar">
                        </a>

                        <div class="info">
                            <a href="{{ $perfilRoute }}" class="nombre">
                                <p>{{ $isRestaurant ? $sugerencia->restaurant->name : $sugerencia->person->first_name . ' ' . $sugerencia->person->last_name }}</p>
                            </a>
                            <p class="tipo-foodie">{{ $tipoFoodie }}</p>
                        </div>

                        <button class="follow-button" data-following="{{ $yaSigo ? 'true' : 'false' }}" data-profile-id="{{ $sugerencia->id }}"> {{ $yaSigo ? 'Dejar de seguir' : 'Seguir' }}</button>
                    </div>
                @empty
                    <p class="mensaje-vacio">No hay sugerencias por ahora.</p>
                @endforelse

            </div>
            <a class="ver-mas" href="{{ route('red.user')}}">Ver más</a>
        </div>
    </div>
</div>

@endsection