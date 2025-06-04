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
    {{-- Habilitar Turbo en todas las vistas --}}
    {{-- <script type="module" src="{{ asset('js/turbo.js') }}" defer></script> --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="componentes-principales profile-styles-users">
        @include('partials.sidebar-restaurante')
        <main>
        {{-- Verificar si el usuario que ingresa es dueño de ese perfil --}}

            @php
                $authRestaurant = auth('restaurant')->check() ? auth('restaurant')->user() : null;
            @endphp

            @if($authRestaurant)
                <div class="panel-de-control">
                    <div class="panel-control-ayuda">
                        <a class="btn-panel" aria-label="Abrir ajustes" href="{{ route('ajustes.restaurante') }}">
                            <i id="panel-ajustes" class="fa-solid fa-gear"></i>
                        </a>

                        <button id="panel-control-logout" class="btn-panel" aria-label="Cerrar sesión" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i style="cursor: pointer;" id="panel-logout" class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </div>
                </div>
            @endif

             <div class="header-profile" 

                @if($profile->coverPhoto)
                    style="background-image: url('{{ $profile->coverPhoto->url }}');"
                @endif>

                <div class="header-profile-cover-name">
        
                    {{-- Versión de móvil --}}
                    <div class="picture-header-profile mobile-version">
                        <img id="profileImageMobile" src="{{ optional($profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Imagen de perfil del usuario">
                    </div> 
                    
                    {{-- Nombre del usuario--}}
                    <div class="nombre-header-profile">
                        <h2>{{ $profile->person->first_name }} {{ $profile->person->last_name }}</h2>
                    </div>
                </div>

                {{-- <pre>{{ dd($profile->profilePhoto)--}}
                {{-- Foto de perfil --}}
                <div class="picture-header-profile">
                   <img id="profileImage" src="{{ optional($profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Imagen de perfil del usuario">
                </div> 
            </div>

            <div class="estructura-perfil">
                <div class="contenidos">
                       
                    {{-- Aquí es donde van los Posts que se generan dinámicamente --}}
                    @yield('content')
                </div>
                <div class="descripcion-user">
                    <h3 class="descripcion-foodie-type">{{ $tipoFoodie }}</h3>
                    <div class="numero-reviews">
                        <div class="numero">
                            <p>{{ $numeroPosts }}</p>
                        </div>
                        <p>publicaciones</p>
                    </div>
                    <div class="localizacion-usuario">
                        <i class="fa-solid fa-map-pin"></i>
                        <p>{{ $ubicacion }}</p>
                    </div>
                    <p class="edad-descripcion">{{ $edad }} años </p>
                    <div class="texto-descripcion">
                        <p>{{ $description }}</p>
                    </div>
                </div>
            </div>
            
        </main>
        {{--Para procesar la petición de tipo POST al hacer logout, se debe abrir un formulario oculto--}}
        @if(auth('restaurant')->check())
            <form id="logout-form" action="{{ route('logout.restaurant') }}" method="POST" style="display:none;">
                @csrf
            </form>
        @endif     
    </div>
</body>
</html>

{{-- Esta vista es para que un usuario restaurante pueda ver el perfil de una persona--}}