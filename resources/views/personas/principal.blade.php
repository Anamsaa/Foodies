@extends('layouts.layout-principal')
@section('title', 'Principal')
@section('description', 'Únete a la comunidad de apasionados por la cocina. Comparte tus platos, sigue a otros foodies y vive la experiencia gastronómica online.')
@section('content')

<div class="principal-container">
    <div class="column-1">
        <div class="creador-post" id="creador-post">
            <img  class="imagen-usuario" src="{{ optional($perfil->profilePhoto)->url ?? asset('images/default_image_profile.png') }} " alt="Imagen de perfil usuario">
            <div class="post-writer-container">
                <div class="simulated-input" id="simulador-input" data-url="{{ route('redactar.post') }}">
                    Cuéntales a tus amigos que se te antoja comer hoy...
                </div>
                <div class="botones">
                        <a href="{{ route('redactar.review') }}">Nueva reseña</a>
                        <a href="{{ route('redactar.evento') }}">Nuevo evento</a>
                </div>
            </div>
        </div>
        <div id="post-usuarios">
            {{-- @forelse($posts as $post)
                @include('components.posts.post', ['post' => $post])
                @empty
                <p class="no-post-message">No hay publicaciones todavía.</p>
            @endforelse --}}
        </div>
    </div>
    <div class="column-2">
        <div class="novedades-container">
            <h2>Últimas Novedades</h2>
            <div id="contenedor-novedades">
                {{-- Aquí van notificiaciones de personas que acaban de seguir al usuario --}}
            </div>
        </div>
        <div class="encontrar-amigos">
            <h2>Sigue a otros</h2>
            <div id="seguir-usuarios">
                {{-- Aquí van recomendaciones de personas a las cuales seguir basados en aspectos de ubicación y seguidos--}}
            </div>
            <a class="ver-mas" href="{{ route('red.user')}}">Ver más</a>
        </div>
    </div>
</div>

@endsection