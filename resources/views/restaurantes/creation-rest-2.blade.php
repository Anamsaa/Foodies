@extends('layouts.layout-creacion-perfil')
@section('title', 'Crear perfil')
@section('description', 'Registra tu restaurante en Foodies y atrae a nuevos clientes a tu negocio.')

@section('contenido-formulario')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="contenedor-registro-restaurante">
        <div class="titulo-formulario-restaurante">
            <h1>Creación de perfil - 2 parte</h1>
            <div class="indice">
                <div class="pagina 1">
                    <p>2/2</p>
                </div>
            </div>
        </div>
        <h3 class="titulo-contacto-2">Datos de contacto</h3>
        <form action="{{ route('crear-perfil.restaurante-2') }}" method="POST" enctype="multipart/form-data" data-contexto="restaurante">
            @csrf
            <div class="grid ">
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="telefono">Número de contacto </label>
                        <input type="text" id="telefono" name="telefono"  value="{{ old('telefono', session('restaurant_step2.telefono')) }}"placeholder="Ej: +34 600 123 456" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="direccion">Dirección </label>
                        <input type="text" id="direccion" name="direccion"  value="{{ old('direccion', session('restaurant_step2.direccion')) }}"placeholder="Ej: Av. Las Palmas, 7" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="direccion_confirmacion">Repite la dirección </label>
                        <input type="text" id="direccion_confirmacion" name="direccion_confirmacion" value="{{ old('direccion_confirmacion', session('restaurant_step2.direccion_confirmacion')) }}" placeholder="Ej: Av. Las Palmas, 7" required>
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
                <div class="column">
                </div>
            </div>
            <div class="button-formulario parte-2">
                <button class="button-restaurantes-formulario" name="_action" value="back" type="submit">Volver atrás</button>
                {{-- Pruebas de flujo de actividad --}}
                {{-- <a class="button-restaurantes-formulario" href="{{ route('crear-perfil.restaurante') }}" type="submit">Volver atrás</a> --}}
                <button class="button-restaurantes-formulario" name="_action" value="next" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
    
@endsection
