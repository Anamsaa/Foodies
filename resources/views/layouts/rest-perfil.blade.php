<!DOCTYPE html>
<html lang="en">
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

</head>
<body>
    <div class="componentes-principales">
        @include('partials.sidebar-restaurante')
        <main>
            {{-- Verificar si el usuario que ingresa es dueño de ese perfil --}}
            @php 
                $esPropietario = auth('restaurant')->user()->profile->id === $perfil->id;
            @endphp

            <div class="panel-de-control">
                <div class="panel-control-ayuda">
                    <a class="btn-panel" aria-label="Abrir ajustes" href="{{ route('ajustes.restaurant') }}"><i id="panel-ajustes" class="fa-solid fa-gear"></i></a>
                
                    <button id="panel-control-logout" class="btn-panel" aria-label="Cerrar sesión" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i id="panel-logout" class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </div>
            </div>

             <div class="header-profile" 
                @if(auth('restaurant')->user()->profile->coverPhoto)
                style="background-image: url('{{ auth('restaurant')->user()->profile->coverPhoto->url }}');"
                @endif> 

                <div class="header-profile-cover-name">
                     {{-- Foto de portada --}}
                    @if($esPropietario)
                        <label class="upload-cover">
                            <i class="fa-solid fa-camera"></i>
                            <input type="file" name="cover_photo" accept="image/**" hidden>
                        </label>
                    @endif

                    <div class="picture-header-profile mobile-version">
                        <img id="profileImage" src="{{ auth('restaurant')->user()->profile->profilePhoto->url ?? asset('images/default-profile.png') }}" alt="Imagen de perfil de restaurante">
                        @if($esPropietario)
                            <label class="upload-profile">
                                <i class="fa-solid fa-camera"></i>
                                <input type="file" name="profile_photo" accept="image/**" hidden>
                            </label>
                        @endif
                    </div> 
                    
                    {{-- Nombre del usuario--}}
                    <div class="nombre-header-profile">
                        <h2>{{ auth('restaurant')->user()->profile->restaurant->name }}</h2>
                    </div>
                </div>

                {{-- Foto de perfil --}}
                <div class="picture-header-profile">
                    <img id="profileImage" src="{{ auth('restaurant')->user()->profile->profilePhoto->url ?? asset('images/default-profile.png') }}" alt="Imagen de perfil de restaurante">
                    <label class="upload-profile">
                        <i class="fa-solid fa-camera"></i>
                        <input type="file" name="profile_photo" accept="image/**" hidden>
                    </label>
                </div> 
            </div>

            <div class="estructura-perfil">
                <div class="contenidos">
                        <p>hola</p>
                        <p>solo aparece en el perfil</p>
                    {{-- Aquí es donde van los Posts que se generan dinámicamente --}}
                    @yield('content')2
                </div>
                <div class="descripcion-user resturante-profile-description">
                    <h3 class="restaurant-type">{{ $tipoRestaurante}}</h3>
                    <div class="horario-apertura">
                        <h3>Horarios:</h3>
                        <p>{{ $horarios }}</p>
                    </div>
                    <div class="dias-apertura">
                        <h3>Días de apertura:</h3>
                        <p>{{ $diasApertura }}</p>
                    </div>
                    <div class="localizacion-usuario">
                        <i class="fa-solid fa-map-pin"></i>
                        <p>{{ $ubicacion }}</p>
                    </div>
                    <div class="numero-telefonico">
                        <p>{{ $numeroTelefonico }}</p>
                    </div>
                    <div class="texto-descripcion">
                        <p>{{ $invitacion }}</p>
                    </div>
    
                    {{-- Un usuario de tipo restaurante, puede ser seguido, pero no que lo sigan --}}
                    @if(!$esPropietario && $esPropietario) 
                        <button type="button" id="seguir" class="seguir">Seguir</button>
                    @endif
                </div>
            </div>
            
        </main>
        {{--Para procesar la petición de tipo POST al hacer logout, se debe abrir un formulario oculto--}}
        <form id="logout-form" action="{{ route('logout.user') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>