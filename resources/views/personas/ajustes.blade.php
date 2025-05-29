@extends('layouts.layout-menu-panel')
@section('title', 'Ajustes')
@section('description', 'Configuración de datos en Foodies')
@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="formulario-ajustes-user">
        <h2>Ajustes</h2>
        <form class="edit-profile-settings" action="{{ route('ajustes.update') }}" method="POST" enctype="multipart/form-data" data-contexto="persona">
            @csrf

            <div class="conf-cuenta">
                {{-- Configuración de nuevo email o contraseña de la cuenta --}}
                {{-- Tabla afectada: Accounts --}}
                <h3>Configuraciones de cuenta: </h3>
                <div class="contenedor-formulario">
                    <label for="email">Cambiar email</label>
                    <input type="email" name="email" id="email" placeholder="{{ old('email', $user->email ?? '') }}">
                    @error('email')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                <div class="contenedor-formulario">
                    <label for="email_confirmation">Repite el email</label>
                    <input type="email" name="email_confirmation" id="email_confirmation">
                </div>
                <div class="contenedor-formulario">
                    <label for="password">Cambiar Contraseña</label>
                    <input type="text" name="password" id="password">
                    @error('password')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                <div class="contenedor-formulario">
                    <label for="password_confirmation">Repite la contraseña</label>
                    <input type="text" name="password_confirmation" id="password_confirmation">
                </div>
            </div>

            <div class="conf-perfil">
                {{-- Edición de los datos  del perfil restaurante --}}
                {{-- Tablas afectadas: Profiles y People --}}
                <h3>Edición de perfil</h3>
                <div class="contenedor-formulario">
                    <label for="first_name">Nombres: </label>
                    <input type="text" id="nombre-ajustes" name="nombre" value="{{ old('first_name', $perfil->person->first_name ?? '') }}">
                    @error('first_name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                <div class="contenedor-formulario">
                    <label for="last_name">Apellidos: </label>
                    <input type="text" id="apellidos-ajustes" name="last_name" value="{{old('last_name', $perfil->person->last_name ?? '')}}">
                    @error('last_name')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                <div class="contenedor-formulario">
                    <label for="fnacimiento">Cambiar fecha de nacimiento: </label>
                    <input type="date" id="fnacimiento-ajustes" name="fnacimiento">
                    @error('fnacimiento')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>

                <div class="contenedor-formulario">
                    <label for="descripcion-usuario">Cambiar descripción</label>
                    <textarea name="descripcion-usuario" id="descripcion-usuario-ajustes" >{{ old('descripcion-usuario', $perfil->person->description) }}</textarea>
                </div>  

                <h3>Cambiar datos de ubicación: </h3>
                <div class="contenedor-formulario select-content">
                    <label for="comunidad-autonoma">Comunidad Autónoma: </label>
                    <select name="comunidad-autonoma" id="comunidad-autonoma">
                        <option value="">Seleccione su Comunidad</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="contenedor-formulario select-content">
                    <label for="provincia">Provincia: </label>
                    <select name="provincia" id="provincia">
                        <option value="">Seleccione su Provincia</option>
                    </select>
                    @error('provincia')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
                <div class="contenedor-formulario select-content">
                    <label for="ciudad">Ciudad: </label>
                    <select name="ciudad" id="ciudad">
                        <option value="">Seleccione su Ciudad</option>
                    </select>
                    @error('ciudad')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        
            <button class="button-usuarios-formulario" type="submit">Actualizar cambios</button>
        </form>

        {{-- Cambio de imagenes para dejar fotos de perfil y portada en null y que el usuario pueda quedarse con la default en profile y el fondo de color en el background --}}
        <div class="change-images">
            {{-- Tablas afectadas: Profiles y Photos --}}
            <form method="POST" action="{{ route('perfil.eliminar.foto') }}" onsubmit="return confirm('¿Seguro que quieres quitar tu foto de perfil?')">
                <p>Configurar foto de perfil por defecto</p>
                @csrf
                <input type="hidden" name="tipo" value="perfil">
                <button type="submit">Quitar foto de perfil</button>
            </form>
        
            <form method="POST" action="{{ route('perfil.eliminar.foto') }}" onsubmit="return confirm('¿Seguro que quieres quitar tu foto de portada?')">
                <p>Configurar foto de portada por defecto</p>
                @csrf
                <input type="hidden" name="tipo" value="portada">
                <button type="submit">Quitar foto de portada</button>
            </form>      
        </div>

        {{-- ** DANGER ** --}}
        {{-- Eliminación de la cuenta --}}
        <form class="eliminar-cuenta" method="POST" action="{{ route('user.delete') }}" onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <h3>Eliminar cuenta y registros: </h3>
            <button class="btn-danger" id="eliminar-cuenta-user">Eliminar cuenta</button>
        </form>
    </div>
@endsection