@extends('layouts.layout-register')
@section('title', 'Regístrate')
@section('description', 'Regístrate y haz nuevos amigos en Foodies, la red social para comer y conocer gente.')
@section('titulo', 'Nuevo por aquí ¡Únete!')
@section('titulo-section', 'Regístrate')

@section('formulario')

<form action="" class="formulario-lr">
    <div class="formulario-login-users">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">
    </div>
    <div class="formulario-login-users">
        <label for="">Repite el email</label>
        <input type="email" name="email" id="email">
    </div>
    <div class="formulario-login-users">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="formulario-login-users">
        <label for="password">Repite la contraseña</label>
        <input type="password" name="password" id="password">
    </div>
    <button type="submit" class="button-formulario">Regístrate</button>
</form>

@endsection
@section('Invitacion', '¿Tienes un negocio dedicado a la restauración?')
@section('enlace-creacion-perfil', '{{  }}')