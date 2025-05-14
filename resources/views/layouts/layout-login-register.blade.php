<!DOCTYPE html>
<html lang="en" class="layout-login-register">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Foodies')</title>
    <meta name="description" content="@yield('description', 'Social Network for foodies')">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('../images/logo-favicon.png') }}">
</head>
<body class="layout-inicio">
    <header>
        <div class="image-logo">
            <img src="{{ asset('images/logo-foodies.png') }}" alt="Logo Red Social Foodies">
        </div>
    </header>
    <section class="background-section">
        <div class="fondo-formulario">  
            <div class="titulo-bienvenida">
                <h3>@yield('titulo', 'Bienvenido')</h3>
            </div>
        </div>
        <div class="contenedor-formulario">    
            <h3 class="titulo-fondo-formulario">@yield('titulo-section')</h3>
            @yield('formulario')
            {{-- <form action="">
                @csrf
            <button type="submit">@yield('buttton-form', 'Enviar')</button> 
            </form>--}}  
        </div>
    </section>
    <footer>
        <div class="redireccion-restaurantes">
            <p>¿Tienes un negocio dedicado a la restauración?</p>
            <p>Crea tu perfil<a href="">aquí</a></p>
        </div>
    </footer>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>