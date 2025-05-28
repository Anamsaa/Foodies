@extends('layouts.layout-menu-panel')
@section('title', 'Red de sabores')
@section('description', 'Encuentra nuevos amigos y explora nuevos restaurantes.')
@section('content')
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="contenido-red-de-sabores">
        <div class="header-red-sabores">
            <h2>Red de sabores</h2>
            <form method="GET" action="{{ route('red.user') }}">
                <div class="navegation-bar">
                    <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}">
                    <button type="submit">
                    <i class="fa fa-search"></i>
                    </button>
                </div>  
            </form>
        </div>

        {{-- Sugerencias de personas --}}
        <h3>Usuarios</h3>
        <div class="usuarios-sugeridos">
            @forelse ($sugerenciasPersonas as $usuario)
                <div class="usuario-card">
                    <img src="{{ optional($usuario->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar">
                    <p>{{ $usuario->person->first_name }} {{ $usuario->person->last_name }}</p>
                    
                    <div class="buttons-card">
                        @php
                            if (auth('user')->check()) {
                                $perfilRoute = route('perfil.user.ajeno', $usuario);
                            } elseif (auth('restaurant')->check()) {
                                $perfilRoute = route('user.perfil.restaurante', $usuario);
                            } else {
                                $perfilRoute = route('landing');
                            }
                         @endphp

                        <a href="{{ $perfilRoute}}">Ver perfil</a>

                        @if(auth('user')->check())
                            <button class="follow-button" data-following="false" data-profile-id="{{ $usuario->id }}">Seguir</button>
                        @endif    
                    </div>
                </div>
            @empty
                 @if (request('search'))
                    <p>No se encontraron coincidencias para "{{request('search') }}".</p>
                @else
                    <p>Lo sentimos, no hay más sugerencias de seguimiento.</p>
                @endif
            @endforelse
        </div>

        {{-- Sugerencias de restaurantes --}}
        <h3>Restaurantes</h3>
        <div class="usuarios-sugeridos">
            @forelse ($sugerenciasRestaurantes as $rest)
                <div class="usuario-card">
                    <img src="{{ optional($rest->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar">
                    <p>{{ $rest->restaurant->name }}</p>
                    
                    <div class="buttons-card">
                        @php
                            if (auth('user')->check()) {
                            // Usuario persona autenticado → usa vista para persona
                                $perfilRestRoute = route('restaurant.perfil.user', $rest);
                            } elseif (auth('restaurant')->check()) {
                            // Restaurante autenticado → usa vista para restaurante
                                $perfilRestRoute = route('perfil.ajeno.restaurante', $rest);
                            } else {
                                $perfilRestRoute = '#'; // o login, o error
                            }
                        @endphp

                        <a href="{{ $perfilRestRoute }}">Ver perfil</a>
                        @if(auth('user')->check())
                            <button class="follow-button" data-following="false" data-profile-id="{{ $rest->id }}">Seguir</button>
                        @endif
                    </div>
                </div>
            @empty
                 @if (request('search'))
                    <p>No se encontraron coincidencias para "{{request('search') }}".</p>
                @else
                    <p>No encontramos más sugerencias de restaurantes en tu provincia :c</p>
                @endif
            @endforelse
        </div>
    </div>
@endsection