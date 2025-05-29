@extends('layouts.layout-register')
@section('title', 'Regístrate')
@section('description', 'Regístrate e impulsa a tu restaurante, creando una cuenta en nuestra red social.')
@section('titulo', 'Nuevo por aquí ¡Impulsa tu negocio!')
@section('titulo-section', 'Regístrate')
@section('restaurant-title-img')
<p class="especificacion">for restaurants</p>
@endsection
@section('formulario')

<form action="{{ route('register.restaurant') }}" method="POST" class="formulario-lr">

    {{-- @php dd('Este es el formulario de restaurante') @endphp --}}
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
        <input type="password" name="password_confirmation" id="password_confirmation" onpaste="return false" oncopy="return false">
    </div>
    <button type="submit" class="button-formulario">Regístrate</button>
</form>

@endsection
@section('Invitacion', 'Ya tienes una cuenta, inicia sesión')
@section('inicio-sesion')
    {{ route('login.restaurant') }}
@endsection