@extends('layouts.rest-menu-panel')
@section('title', 'Ajustes')
@section('description', 'Configuración de datos en Foodies')
@section('content')
    <div class="formulario-ajustes-restaurant">
        <h2>Ajustes</h2>
        <form action="{{ route('.store') }}" method="POST" enctype="multipart/form-data" data-contexto="restaurante" class="formulario-ajustes-rest" id="form-settings-rest">
            @csrf

            {{-- Detalles:  --}}
            {{-- Los atributos values corresponden al ultimo valor configurado por el usuario y que está registrado en la BBBDD --}}

            {{-- Pasos: --}}
            {{-- 
            1. El formulario le muestra al usuario sus el valor de sus úlltimos datos configurados a través del método de renderizado de Perfil del ResturantProfilleController
            2. El usuario envía los datos a través del método POST, es decir, guarda los datos.
            3. Se actualizan los datos en las tablas correspondientes.
            
            Opcional:
            Eliminación de cuenta a través de delete, se borra el resgistro de datos asignados a un perfil 
            
            --}}
            
            {{-- Manejo y aviso de errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    </ul>
                </div>
            @endif

            {{-- Para la configuración de nuevos datos se realiza la validación desde el servidor --}}
            <div class="conf-cuenta">
                {{-- Configuración de nuevo email o contraseña de la cuenta --}}
                <h2>Configuraciones de cuenta: </h2>
                <div class="formulario-login-users">
                    <label for="email">Cambiar email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="formulario-login-users">
                    <label for="email_confirmation">Repite el email</label>
                    <input type="email" name="email_confirmation" id="email_confirmation">
                </div>
                <div class="formulario-login-users">
                    <label for="password">Cambiar Contraseña</label>
                    <input type="password" name="password" id="password">
                </div>
                <div class="formulario-login-users">
                    <label for="password_confirmation">Repite la contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>
            </div>
            
            <div class="conf-perfil">
                {{-- Edición de los datos  del perfil restaurante --}}
                <h2>Edición de perfil</h2>
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombre del establecimiento </label>
                        <input type="text" id="nombre" name="nombre" value="{{}}">
                    </div>
                    <div class="contenedor-formulario">
                        <label for="horarios">Comenta brevemente los horarios que maneja tu negocio: </label>
                        <textarea name="horarios" id="horarios">{{}}</textarea>
                    </div>
                    <div class="contenedor-formulario">
                        <p>Días de apertura:</p>
                        @php
                            $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $seleccionados = old('dias_apertura', session('restaurant_step1.dias_apertura', []));
                        @endphp

                        @foreach ($dias as $dia)
                            <div class="choose-days">
                                <input type="checkbox" id="{{ strtolower($dia) }}" name="dias_apertura[]" value="{{ $dia }}"
                                {{ in_array($dia, $seleccionados) ? 'checked' : '' }}>
                                <label for="{{ strtolower($dia) }}">{{ $dia }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="link-restaurante">Cambiar el link de la web: </label>
                        <input type="text" id="link-restaurante" name="link-restaurante" value="{{ }}">
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="tipo-restaurante">Cambiar el tipo de restaurante: </label>
                        <select name="tipo" id="tipo-restaurante" data-old-value="{{}}">
                            <option value="">Tipos de restaurante</option>
                        </select>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="invitacion">Modificar invitación: </label>
                        <textarea name="invitacion" id="invitacion">{{ }}</textarea>
                    </div>
                </div>
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="telefono">Cambiar número de contacto</label>
                        <input type="text" id="telefono" name="telefono"  value="{{  }}">
                    </div>
                    <div class="contenedor-formulario">
                        <label for="direccion"> Cambiar dirección </label>
                        <input type="text" id="direccion" name="direccion"  value="{{  }}">
                    </div>
                    <div class="contenedor-formulario">
                        <label for="direccion_confirmacion">Repite la dirección </label>
                        <input type="text" id="direccion_confirmacion" name="direccion_confirmacion" value="">
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="comunidad-autonoma">Comunidad Autónoma: </label>
                        <select name="comunidad-autonoma" id="comunidad-autonoma" class="select-comunidad-autonoma" data-selected="{{ old('comunidad-autonoma') }}">
                            <option value="">Seleccione su Comunidad</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="provincia">Provincia: </label>
                        <select name="provincia" id="provincia" class="select-provincia" data-selected="{{ old('provincia') }}">
                            <option value="">Seleccione su Provincia</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="ciudad">Ciudad: </label>
                        <select name="ciudad" id="ciudad" class="select-ciudad" data-selected="{{ old('ciudad') }}">
                            <option value="">Seleccione su Ciudad</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
            </div>

            {{-- Cambio de imagenes para dejar fotos de perfil y portada en null y que el usuario pueda quedarse con la default en profile y el fondo de color en el background --}}
            <div class="change-images">

            </div>
        
            <button class="button-usuarios-formulario" type="submit">Actualizar cambios</button>
        </form>

        {{-- ** DANGER ** --}}
        {{-- Eliminación de la cuenta --}}
        <form method="POST" action="{{ route('restaurant.delete') }}" onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')">
            @csrf
            @method('DELETE')
            <button class="btn-danger" id="eliminar-cuenta-user">Eliminar cuenta</button>
        </form>
    </div>
@endsection