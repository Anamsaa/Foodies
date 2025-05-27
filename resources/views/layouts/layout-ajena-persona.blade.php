<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Foodies')</title>
    <meta name="description" content="@yield('description', 'Social Network for foodies')">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-favicon.png') }}">
    {{-- Token CSFR --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="componentes-principales profile-styles-users">
        @include('partials.sidebar')
         @php
            $authRestaurant = auth('restaurant')->check() ? auth('restaurant')->user() : null;
            $esPropietario = $authRestaurant && $authRestaurant->profile && $authRestaurant->profile->id === $perfil->id;
            $coverPhotoUrl = $authRestaurant?->profile?->coverPhoto?->url;
            $restaurantName = $authRestaurant?->profile?->restaurant?->name ?? $perfil->restaurant->name;
        @endphp

        <main>
            {{-- Panel de control solo visible para restaurantes --}}
            @if($authRestaurant)
                <div class="panel-de-control">
                    <div class="panel-control-ayuda">
                        <a class="btn-panel" aria-label="Abrir ajustes" href="{{ route('ajustes.restaurante') }}">
                            <i id="panel-ajustes" class="fa-solid fa-gear"></i>
                        </a>

                        <button id="panel-control-logout" class="btn-panel" aria-label="Cerrar sesión" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i id="panel-logout" class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </div>
                </div>
            @endif

            <div class="header-profile" 
                @if($coverPhotoUrl)
                    style="background-image: url('{{ $coverPhotoUrl }}');"
                @endif>

                <div class="header-profile-cover-name">
                    {{-- Foto de portada --}}
                    @if($esPropietario)
                        <label class="upload-cover">
                            <i class="fa-solid fa-camera"></i>
                            <input type="file" name="cover_photo" accept="image/**" hidden>
                        </label>
                    @endif

                    {{-- Versión móvil --}}
                    <div class="picture-header-profile mobile-version">
                        <img id="profileImageMobile" src="{{ $perfil->profilePhoto->url ?? asset('images/default_image_profile.png') }}" alt="Imagen de perfil de restaurante">
                        @if($esPropietario)
                            <label class="upload-profile">
                                <i class="fa-solid fa-camera"></i>
                                <input type="file" name="profile_photo" accept="image/**" hidden>
                            </label>
                        @endif
                    </div>

                    {{-- Nombre del restaurante --}}
                    <div class="nombre-header-profile">
                        <h2>{{ $restaurantName }}</h2>
                    </div>
                </div>

                {{-- Foto de perfil (versión escritorio) --}}
                <div class="picture-header-profile">
                    <img id="profileImage" src="{{ $perfil->profilePhoto->url ?? asset('images/default_image_profile.png') }}">
                    @if($esPropietario)
                        <label class="upload-profile">
                            <i class="fa-solid fa-camera"></i>
                            <input type="file" name="profile_photo" accept="image/**" hidden>
                        </label>
                    @endif
                </div>
            </div>

            <div class="estructura-perfil">
                <div class="contenidos">
                    @yield('content')
                </div>

                <div class="descripcion-user resturante-profile-description">
                    <h3 class="restaurant-type">{{ $tipoRestaurante }}</h3>

                    <div class="horario-apertura">
                        <h3>Horarios:</h3>
                        <p>{{ $horarios }}</p>
                    </div>

                    <div class="dias-apertura">
                        <h3>Apertura:</h3>
                        <p>{{ $perfil->restaurant->dias_apertura_texto }}</p>
                    </div>

                    <div class="localizacion-usuario">
                        <i class="fa-solid fa-map-pin"></i>
                        <p>{{ $ubicacion }}</p>
                    </div>

                    <div class="direccion-restaurante">
                        <p class="titulo">Dirección:</p>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ rawurlencode($direccion) }}" target="_blank">{{ $direccion }}</a>
                    </div>

                    <div class="numero-telefonico">
                        <a href="tel:{{ $numeroTelefonico }}">{{ $numeroTelefonico }}</a>
                    </div>

                    <a class="website-link" href="{{ $website }}" target="_blank">Sitio Oficial</a>

                    <div class="texto-descripcion">
                        <p>{{ $descripcion }}</p>
                    </div>

                    {{-- Botón seguir solo para usuarios tipo persona --}}
                    @if(!$esPropietario && auth('user')->check())
                        <button type="button" id="seguir" class="seguir">Seguir</button>
                    @endif
                </div>
            </div>
        </main>

        {{-- Logout solo si hay restaurante autenticado --}}
        @if(auth('restaurant')->check())
            <form id="logout-form" action="{{ route('logout.restaurant') }}" method="POST" style="display:none;">
                @csrf
            </form>
        @endif     
    </div>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>

{{-- **NOTA** --}}
{{-- Esta vista es para que un usuario persona pueda ver el perfil de un restaurante--}}