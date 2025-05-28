@extends('layouts.layout-menu-panel')
@section('title', 'Seguidos')
@section('description', 'Sigue a la comunidad de foodies')
@section('content')
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="lista-seguidos">
        <div class="header-seguidos">
            <h2>Seguidos (<span id="seguidores-contador">{{ $numeroSeguidos }}</span>)</h2>
            <form method="GET" action="{{ route('seguidos.user') }}">
                <div class="navegation-bar">
                    <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>  
            </form>
        </div>

        <div class="usuarios-seguidos">
            @forelse ($seguidos as $usuario)
                <div class="usuario-card">
                    <img src="{{ optional($usuario->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar">
                    
                    <p>
                        @if($usuario->user_type === 'Person')
                            {{ $usuario->person->first_name }} {{ $usuario->person->last_name }}
                        @elseif($usuario->user_type === 'Restaurant')
                            {{ $usuario->restaurant->name }}
                        @endif
                    </p>

                    @php
                        $perfilRoute = $usuario->user_type === 'Person'
                            ? route('perfil.user.ajeno', $usuario)
                            : route('restaurant.perfil.user', $usuario);
                    @endphp

                    <div class="button-seguidos">
                        <a href="{{ $perfilRoute }}">Ver perfil</a>
                        <button class="follow-button" data-following="true" data-profile-id="{{ $usuario->id }}">Dejar de seguir</button>
                    </div>
                    
                </div>
            @empty
                @if (request('search'))
                    <p>No se encontraron coincidencias para "{{ request('search') }}".</p>
                @else
                    <p>No sigues a nadie aún.</p>
                @endif
            @endforelse
        </div>
    </div>
@endsection