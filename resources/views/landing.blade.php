<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
    <title>@yield('title', 'Foodies')</title>
    <meta name="description" content="Foodies is a Social Netwotk for eat and make new friends, what are you waiting for trying?">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-favicon.png') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="landing-body">
    <nav class="landing-bar">
        <div class="landing-logo-bar">
            <a href="{{ route('landing') }}"><img src="{{ asset('images/logo-foodies.png') }}" alt="Logo Foodies"></a>
        </div>
        <div class="landing-texto-bar">
            <a class="inicio-sesion" href="{{ route('login.user') }}">Iniciar Sesión</a>
            <a class="registro-negocio" href="{{ route('register.restaurant') }}">Tengo un negocio</a>
        </div>

        {{-- Menú hamburguesa landing --}}
        <div class="menu-hamburguesa-landing">
            <button id="boton-hamburguesa-landing" class="btn-menu" aria-label="Abrir menú">
                <i id="hamburguesa-icon-landing" class="fas fa-bars"></i>
            </button>
        </div>
    </nav>


    {{-- Menú lateral emergente  --}}
    <div class="menu-emergente-landing oculto" id="menu-lateral-landing">
        <button id="boton-cerrar-landing" class="btn-menu" aria-label="Cerrar menú lateral">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <ul class="opciones-menu-landing">
            <li class="apartados-landing"><a href="{{ route('login.user') }}">Iniciar Sesión</a></li>
            <li class="apartados-landing"><a href="{{ route('register.restaurant') }}">Tengo un negocio</a></li>
        </ul>
    </div>


    <main class="landing-main">
        <div class="texto-main">
            <p class="slogan-main">find a <span class="enfasis">friend</span>,find a <span class="enfasis">meal</span>.</p>
            <p class="description-main">¡Bienvenido a <b>Foodies</b>! la red social para conectar con personas reales a través de la comida.
            Comparte experiencias, crea eventos culinarios, apoya restaurantes locales y construye nuevas amistades.</p>
            <a class="boton-main" href="{{ route('register.user') }}">Únete</a>
        </div>
        <div class="ilustracion-main">
            <img src="{{ asset('images/ilustracion_personas_comiendo.svg') }}" alt="Ilustración de pareja comiendo">
        </div>
    </main>
    <footer class="landing-footer">
        <div>
            <p>&copy; 2025 Foodies. Developed by <a href="https://github.com/Anamsaa" target="_blank" rel="noopener noreferrer">Ana Saavedra</a></p>
            <p>Ilustración por <a href="https://storyset.com/together" class="underline text-blue-400" target="_blank" rel="noopener noreferrer">Storyset</a></p>
            <p>TFG DAW</p>
        </div>
    </footer>
</body>
</html>