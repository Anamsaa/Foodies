@extends('layouts.layout-register')
@section('title', 'Regístrate')
@section('description', 'Regístrate y haz nuevos amigos en Foodies, la red social para comer y conocer gente.')
@section('titulo', 'Nuevo por aquí ¡Únete!')
@section('titulo-section', 'Regístrate')

@section('formulario')

<form action="{{ route('register.user') }}" method="POST" class="formulario-lr">
    @csrf
    <div class="formulario-login-users">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        @error('email')
            <small class="error-message">{{ $message }}</small>
        @enderror
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="formulario-login-users">
        <label for="email_confirmation">Repite el email</label>
        <input type="email" name="email_confirmation" id="email_confirmation" required onpaste="return false" oncopy="return false">
    </div>
    <div class="formulario-login-users">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required>
        @error('password')
            <small class="error-message">{{ $message }}</small>
        @enderror
    </div>
    <div class="formulario-login-users">
        <label for="password_confirmation">Repite la contraseña</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required onpaste="return false" oncopy="return false">
    </div>
    <button type="submit" class="button-formulario">Regístrate</button>
</form>

@endsection
@section('Invitacion', '¿Tienes un negocio dedicado a la restauración? Regístralo')
@section('inicio-sesion', route('register.restaurant'))