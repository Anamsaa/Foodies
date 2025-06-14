@extends('layouts.rest-menu-panel')
@section('title', 'Ajustes')
@section('description', 'Configuración de datos en Foodies')
@section('content')

<div class="styles-form-posts">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="formulario-ajustes-restaurant">
            <h2>Ajustes</h2>
            <form  class="edit-profile-settings" action="{{ route('ajustes.update.rest') }}" method="POST" enctype="multipart/form-data" data-contexto="restaurante" class="formulario-ajustes-rest" id="form-settings-rest">
                @csrf
                {{-- Para la configuración de nuevos datos se realiza la validación desde el servidor --}}
                <div class="conf-cuenta">
                    {{-- Configuración de nuevo email o contraseña de la cuenta --}}
                    <h3>Configuraciones de cuenta: </h3>
                    <div class="contenedor-formulario">
                        <label for="email">Cambiar email</label>
                        <input type="email" name="email" id="email">
                        @error('email')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contenedor-formulario">
                        <label for="email_confirmation">Repite el email</label>
                        <input type="email" name="email_confirmation" id="email_confirmation" onpaste="return false" oncopy="return false">
                    </div>
                    <div class="contenedor-formulario">
                        <label for="password">Cambiar Contraseña</label>
                        <input type="password" name="password" id="password">
                        @error('password')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contenedor-formulario">
                        <label for="password_confirmation">Repite la contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" onpaste="return false" oncopy="return false">
                    </div>
                </div>
                
                <div class="conf-perfil">
                    {{-- Edición de los datos  del perfil restaurante --}}
                    <h3>Edición de perfil</h3>
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombre del establecimiento: </label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $restaurant->name ?? '')}}">
                    </div>
                    <div class="contenedor-formulario">
                        <label for="horarios">Comenta brevemente los horarios que maneja tu negocio: </label>
                        <textarea name="horarios" id="horarios">{{ old('horarios', $restaurant->horarios ?? '') }}</textarea>
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
                    
                    <div class="contenedor-formulario">
                        <label for="link-restaurante">Cambiar el link de la web: </label>
                        <input type="text" id="link-restaurante" name="link-restaurante" value="{{ old('link-restaurante', $restaurant->website ?? '') }}">
                            @error('link-restaurante')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="tipo-restaurante">Cambiar el tipo de restaurante: </label>
                        <select name="tipo" id="tipo-restaurante">
                            <option value="">Tipos de restaurante</option>
                        </select>
                    </div>

                    <div class="contenedor-formulario">
                        <label for="invitacion">Modificar invitación: </label>
                        <textarea name="invitacion" id="invitacion">{{ old('invitacion', $restaurant->description ?? '') }}</textarea>
                    </div>
                
                    <div class="contenedor-formulario">
                        <label for="telefono">Cambiar número de contacto</label>
                        <input type="text" id="telefono" name="telefono"   value="{{ old('telefono', $restaurant->description ?? '' )}}">
                        @error('telefono')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="contenedor-formulario">
                        <label for="direccion"> Cambiar dirección </label>
                        <input type="text" id="direccion" name="direccion"  value="{{ old('direccion', $restaurant->address ?? '') }}">
                        @error('direccion')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="contenedor-formulario">
                        <label for="direccion_confirmacion">Repite la dirección </label>
                        <input type="text" id="direccion_confirmacion" name="direccion_confirmacion">
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="comunidad-autonoma">Comunidad Autónoma: </label>
                        <select name="comunidad-autonoma" id="comunidad-autonoma" class="select-comunidad-autonoma" data-selected="{{ old('comunidad-autonoma') }}">
                            <option value="">Seleccione su Comunidad</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="provincia">Provincia: </label>
                        <select name="provincia" id="provincia" class="select-provincia" data-selected="{{ old('provincia') }}">
                            <option value="">Seleccione su Provincia</option>
                        </select>
                        @error('provincia')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="ciudad">Ciudad: </label>
                        <select name="ciudad" id="ciudad" class="select-ciudad" data-selected="{{ old('ciudad') }}">
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
                <form method="POST" action="{{ route('rest.eliminar.foto') }}" onsubmit="return confirm('¿Seguro que quieres quitar tu foto de perfil?')">
                    <h3>Configurar foto de perfil por defecto</h3>
                    @csrf
                    <input type="hidden" name="tipo" value="perfil">
                    <button type="submit">Quitar foto de perfil</button>
                </form>
            
                <form method="POST" action="{{ route('rest.eliminar.foto') }}" onsubmit="return confirm('¿Seguro que quieres quitar tu foto de portada?')">
                    <h3>Configurar foto de portada por defecto</h3>
                    @csrf
                    <input type="hidden" name="tipo" value="portada">
                    <button type="submit">Quitar foto de portada</button>
                </form>      
            </div>

            {{-- ** DANGER ** --}}
            {{-- Eliminación de la cuenta --}}
            <form class="eliminar-cuenta" method="POST" action="{{ route('rest.delete') }}" onsubmit="return confirm('¿Estás seguro de eliminar tu cuenta? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <h3>Eliminar cuenta y registros: </h3>
                <button class="btn-danger" id="eliminar-cuenta-user">Eliminar cuenta</button>
            </form>
        </div>
    </div>
@endsection