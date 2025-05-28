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
    {{-- Habilitar Turbo en todas las vistas --}}
    {{-- <script type="module" src="{{ asset('js/turbo.js') }}" defer></script> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="componentes-principales">
        @include('partials.sidebar-restaurante')
        <main>
            <div class="panel-de-control">
                <div class="panel-control-ayuda">
                    <a class="btn-panel" aria-label="Abrir ajustes" href={{ route('ajustes.restaurante') }}><i id="panel-ajustes" class="fa-solid fa-gear"></i></a>
                
                    <button id="panel-control-logout" class="btn-panel" aria-label="Cerrar sesión" onclick="event.preventDefault(); document.getElementById('logout-form-rest').submit();">
                        <i id="panel-logout" class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </div>
            </div>
            <div class="contenidos rest-main-dashboard">
                    @yield('content')
            </div>
        </main>
          {{--Para procesar la petición de tipo POST al hacer logout, se debe abrir un formulario oculto--}}
        <form id="logout-form-rest" action="{{ route('logout.restaurant') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>