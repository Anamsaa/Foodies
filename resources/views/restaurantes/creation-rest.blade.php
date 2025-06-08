@extends('layouts.layout-creacion-perfil')
@section('title', 'Crear perfil')
@section('description', 'Registra tu restaurante en Foodies y atrae a nuevos clientes a tu negocio.')

@section('contenido-formulario')
    <div class="contenedor-registro-restaurante">
        <div class="titulo-formulario-restaurante">
            <h1>Creación de perfil - restaurantes</h1>
            <div class="indice">
                <div class="pagina 1">
                    <p>1/2</p>
                </div>
            </div>
        </div>
        <form action="{{ route('crear-perfil.restaurante.guardar') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="grid">
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombre del establecimiento </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Tacos XtremeFusion" value="{{ old('nombre', session('restaurant_step1.nombre')) }}" required>
                    </div>
                    @error('nombre')
                        <small class="error-message">{{ $message }}</small>
                    @enderror
                    <div class="contenedor-formulario">
                        <label for="horarios">Comenta brevemente los horarios que maneja tu negocio: </label>
                        <textarea name="horarios" id="horarios" rows="6" cols="50" placeholder="Ej: Jueves y Viernes 18:00 a 22:00 | Domingos y Sábados de 18:00 a 23:00">{{ old('horarios', session('restaurant_step1.horarios')) }}</textarea>
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
                        <label for="link-restaurante">Link de tu web oficial: </label>
                        <input type="text" id="link-restaurante" name="link-restaurante" placeholder="Ej: www.mirestaurante.es"  value="{{ old('link-restaurante', session('restaurant_step1.link-restaurante')) }}">
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="tipo-restaurante">Elige el tipo de restaurante: </label>
                        <select name="tipo" id="tipo-restaurante" data-old-value="{{ old('tipo', session('restaurant_step1.tipo')) }}">
                            <option value="">Tipos de restaurante</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    @error('tipo')
                            <small class="error-message">{{ $message }}</small>
                    @enderror
                    <div class="contenedor-formulario">
                        <label for="invitacion">Invita a los foodies a tu negocio: </label>
                        <textarea name="invitacion" id="invitacion" rows="6" cols="50" placeholder="Ej: '¡Bienvenido a nuestro restaurante! Aquí nuestra especialidad son los tacos al Pastor">{{ old('invitacion', session('restaurant_step1.invitacion')) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-restaurantes-formulario" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
    
@endsection
