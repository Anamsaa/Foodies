@extends('layouts.layout-creacion-perfil')
@section('title', 'Crear perfil')
@section('description', 'Regístrate en Foodies donde puedes compartir tus platos favoritos y conectar con amantes de la gastronomía como tú.')

@section('contenido-formulario')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="contenedor-registro-usuario">
        <div class="titulo-formulario-usuario">
            <h1>Creación de perfil</h1>
        </div>
        <form action="{{ route('crear-perfil.guardar') }}" method="POST" enctype="multipart/form-data" data-contexto="persona">
            @csrf
            <div class="grid">
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombres: </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Julian" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="apellidos">Apellidos: </label>
                        <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Ej: Moreno" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="fnacimiento">Fecha de nacimiento: </label>
                        <input type="date" id="fnacimiento" name="fnacimiento" value="{{ old('fnacimiento') }}" required>
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="comunidad-autonoma">Comunidad Autónoma: </label>
                        <select name="comunidad-autonoma" id="comunidad-autonoma">
                            <option value="">Seleccione su Comunidad</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="provincia">Provincia: </label>
                        <select name="provincia" id="provincia">
                            <option value="">Seleccione su Provincia</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="contenedor-formulario select-content">
                        <label for="ciudad">Ciudad: </label>
                        <select name="ciudad" id="ciudad">
                            <option value="">Seleccione su Ciudad</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>

                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="descripcion-usuario">Da una breve descripción de ti</label>
                        <textarea name="descripcion-usuario" id="descripcion-usuario" rows="6" cols="50">{{ old('descripcion-usuario') }}</textarea>
                    </div>  
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-usuarios-formulario" type="submit">Cargar perfil</button>
            </div>
        </form>
    </div>
    
@endsection
