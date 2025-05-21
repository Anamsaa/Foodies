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

                        <!-- <div class="choose-days">
                            <input type="checkbox" id="lunes" name="dias_apertura[]" value="Lunes" {{ old('lunes', session('restaurant_step1.lunes')) ? 'checked' : '' }}>
                            <label for="lunes">Lunes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="martes" name="dias_apertura[]" value="Martes" {{ old('martes', session('restaurant_step1.martes')) ? 'checked' : '' }}>
                            <label for="martes">Martes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="miercoles" name="dias_apertura[]" value="Miércoles" {{ old('miercoles', session('restaurant_step1.miercoles')) ? 'checked' : '' }}>
                            <label for="miercoles">Miércoles</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="jueves" name="dias_apertura[]" value="Jueves" {{ old('jueves', session('restaurant_step1.jueves')) ? 'checked' : '' }}>
                            <label for="jueves">Jueves</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="viernes" name="dias_apertura[]" value="Viernes" {{ old('viernes', session('restaurant_step1.viernes')) ? 'checked' : '' }}>
                            <label for="viernes">Viernes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="sabado" name="dias_apertura[]" value="Sábado" {{ old('sabado', session('restaurant_step1.sabado')) ? 'checked' : '' }}>
                            <label for="sabado">Sábado</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="domingo" name="dias_apertura[]" value="Domingo" {{ old('domingo', session('restaurant_step1.domingo')) ? 'checked' : '' }}>
                            <label for="domingo">Domingo</label>
                        </div> -->
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
                    <div class="contenedor-formulario">
                        <label for="invitacion">Invita a los foodies a tu negocio: </label>
                        <textarea name="invitacion" id="invitacion" rows="6" cols="50" placeholder="Ej: '¡Bienvenido a nuestro restaurante! Aquí nuestra especialidad son los tacos al Pastor">{{ old('invitacion', session('restaurant_step1.invitacion')) }}</textarea>
                    </div>

                    {{--<div class="contenedor-imagenes">
                        <div class="contenedor-formulario cargar-imagenes">
                            <span class="titulo-imagen">Escoge una foto de perfil</span>
                            <label class="upload-box" id="box-perfil">
                                <i class="fa-solid fa-plus"></i>
                                <span>Haz click para seleccionar una imagen</span>
                            </label>

                            <input type="file" name="imagen-perfil" id="imagen-perfil" accept=".jpg, .jpeg, .png, .webp" style="display: none;">

                            @if(session('restaurant_step1.imagen_perfil_path'))
                                <div class="preview-imagen" id="preview-perfil">
                                    <img src="{{ asset('storage/' . session('restaurant_step1.imagen_perfil_path')) }}" alt="Imagen de perfil previa">
                                    <button type="button" class="btn-eliminar" onclick="eliminarImagen('imagen-perfil','box-perfil', 'preview-perfil')">X</button>
                                </div>
                            @endif
                        </div>
                        <div class="contenedor-formulario cargar-imagenes">
                            <span class="titulo-imagen">Escoge una foto de portada</span>
                            <label class="upload-box" id="box-portada">
                                <i class="fa-solid fa-plus"></i>
                                <span>Haz click para seleccionar una imagen</span>
                            </label>

                            <input type="file" name="imagen-portada" id="imagen-portada" accept=".jpg, .jpeg, .png, .webp" style="display: none;">

                            @if(session('restaurant_step1.imagen_portada_path'))
                                <div class="preview-imagen" id="preview-portada">
                                    <img src="{{ asset('storage/' . session('restaurant_step1.imagen_portada_path')) }}" alt="Imagen de portada previa">
                                    <button type="button" class="btn-eliminar" onclick="eliminarImagen('imagen-portada','box-portada', 'preview-portada')">X</button>
                                </div>
                            @endif
                        </div>
                    </div>--}}
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-restaurantes-formulario" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
    
@endsection
