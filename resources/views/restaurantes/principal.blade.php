@extends('layouts.rest-menu-panel')
@section('title', 'Principal')
@section('description', 'Únete a la comunidad de apasionados por la cocina. Comparte tus platos, sigue a otros foodies y vive la experiencia gastronómica online.')
@section('icono-ajustes', route('ajustes.restaurante'))
@section('icono-logout', route('logout.restaurant'))
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="contenidos-principal">
    <div class="principal-container">
        <div class="column-1">
            <div class="creador-post" id="creador-post">
                <a href="{{ get_profile_route($perfil->restaurant->profile) }}"><img  class="imagen-usuario" src="{{ optional($perfil->restaurant->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }} " alt="Imagen de perfil usuario"></a>
                <div class="post-writer-container">
                    <div class="simulated-input" id="simulador-input" data-url="{{ route('redactar.post.restaurant') }}">
                        Cuéntales a los foodies que promociones tienes hoy...
                    </div>
                    <div class="botones">
                            {{-- Próxima ampliación a reseñas --}}
                            {{-- <a href="{{ route('redactar.review') }}">Nueva reseña</a> --}}
                            <a href="{{ route('redactar.post.restaurant') }}">Subir post</a>
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
                    <p class="no-post-message" id="unique-post-message">No hay publicaciones todavía.</p>
                @endforelse
            </div>
        </div>
        <div class="column-2">
            <div class="novedades-container">
                <h2>Últimas Novedades</h2>
                <div id="contenedor-novedades" class="contenedor-novedades">
                    @forelse($misNovedades as $novedad)
                        <div class="novedad-item">
                            <img src="{{ $novedad['foto'] }}" alt="Avatar">
                            <div class="novedad-info">
                                <strong>{{ $novedad['nombre'] }}</strong> ha empezado a seguirte
                                <p>{{ $novedad['tiempo'] }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="mensaje-vacio">Aún no tienes novedades.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection