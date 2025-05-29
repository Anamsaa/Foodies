@extends('layouts.layout-menu-panel')
@section('title', 'Ajustes')
@section('description', 'Configuración de datos en Foodies')
@section('content')

<div class="formulario-ajustes-user">

    {{-- Detalles:  --}}
    {{-- Los atributos values corresponden al ultimo valor configurado por el usuario y que está registrado en la BBBDD --}}

    {{-- Pasos: --}}
    {{-- 
        1. El formulario le muestra al usuario sus el valor de sus úlltimos datos configurados a través del método de renderizado de Perfil del ResturantProfilleController
        2. El usuario envía los datos a través del método POST, es decir, guarda los datos.
        3. Se actualizan los datos en las tablas correspondientes.

        Opcional para el usuario:
        Eliminación de cuenta a través de delete, se borra el resgistro de datos asignados a un perfil 
    --}}

    {{-- Manejo y aviso de errores al hacer submit --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
            </ul>
        </div>
    @endif

    <h2>Ajustes</h2>
    <form action="{{ route('ajustes.update') }}" method="POST" enctype="multipart/form-data" data-contexto="persona">
        @csrf

        <div class="conf-cuenta">
            {{-- Configuración de nuevo email o contraseña de la cuenta --}}
            {{-- Tabla afectada: Accounts --}}
            <h2>Configuraciones de cuenta: </h2>
            <div class="contenedor-formulario">
                <label for="email">Cambiar email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}">
            </div>
            <div class="contenedor-formulario">
                <label for="email_confirmation">Repite el email</label>
                <input type="email" name="email_confirmation" id="email_confirmation">
            </div>
            <div class="contenedor-formulario">
                <label for="password">Cambiar Contraseña</label>
                <input type="text" name="password" id="password">
            </div>
            <div class="contenedor-formulario">
                <label for="password_confirmation">Repite la contraseña</label>
                <input type="text" name="password_confirmation" id="password_confirmation">
            </div>
        </div>

        <div class="conf-perfil">
             {{-- Edición de los datos  del perfil restaurante --}}
            {{-- Tablas afectadas: Profiles y People --}}
            <h2>Configuraciones de cuenta: </h2>
            <h2>Edición de perfil</h2>
            <div class="contenedor-formulario">
                <label for="first_name">Nombres: </label>
                <input type="text" id="nombre-ajustes" name="nombre" value="{{ old('first_name', $perfil->person->first_name ?? '') }}">
            </div>
            <div class="contenedor-formulario">
                <label for="last_name">Apellidos: </label>
                <input type="text" id="apellidos-ajustes" name="last_name" value="{{old('last_name', $perfil->person->last_name ?? '')}}">
            </div>
            <div class="contenedor-formulario">
                <label for="fnacimiento">Cambiar fecha de nacimiento: </label>
                <input type="date" id="fnacimiento-ajustes" name="fnacimiento" value="{{ old('fnacimiento') }}">
            </div>

            <div class="contenedor-formulario">
                <label for="descripcion-usuario">Cambiar descripción</label>
                <textarea name="descripcion-usuario" id="descripcion-usuario-ajustes" >{{ old('descripcion-usuario', $perfil->person->description) }}</textarea>
            </div>  

            <h2>Cambiar datos de ubicación: </h2>
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
            </div>
            <div class="contenedor-formulario select-content">
                <label for="ciudad">Ciudad: </label>
                <select name="ciudad" id="ciudad">
                    <option value="">Seleccione su Ciudad</option>
                </select>
            </div>
        </div>
       
        <button class="button-usuarios-formulario" type="submit">Actualizar cambios</button>
    </form>

    {{-- Cambio de imagenes para dejar fotos de perfil y portada en null y que el usuario pueda quedarse con la default en profile y el fondo de color en el background --}}
    <div class="change-images">
        {{-- Deberia poner un botón para que genere la opción y actualizar la tabla para que los campos de cover_photo_id y profile_photo_id --}}
        {{-- Tablas afectadas: Profiles y Photos --}}
        
    </div>

    {{-- ** DANGER ** --}}
    {{-- Eliminación de la cuenta --}}
    <form method="POST" action="{{ route('user.delete') }}" onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')">
        @csrf
        @method('DELETE')
        <button class="btn-danger" id="eliminar-cuenta-user">Eliminar cuenta</button>
    </form>
</div>

@endsection