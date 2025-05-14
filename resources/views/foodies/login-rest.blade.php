@extends('layouts.layout-login')
@section('title', 'Iniciar Sesión')
@section('description', 'Bienvenido de nuevo, inicia sesión en nuestra Red Social y mantente al tanto de las novedades.')
@section('titulo', 'Welcome again foodie Host :)')
@section('titulo-section', 'Iniciar Sesión')
@section('restaurant-title-img')
<p class="especificacion">for restaurants</p>
@endsection
@section('formulario')

<form action="" class="formulario-lr">
    <div class="formulario-login-users">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </div>
    <div class="formulario-login-users">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit" class="button-formulario">Regístrate</button>
</form>

@endsection
@section('Invitacion', '¿Aún no te has registrado?')
@section('enlace-creacion-perfil', '{{  }}')