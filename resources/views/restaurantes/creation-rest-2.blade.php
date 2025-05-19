@extends('layouts.layout-creacion-perfil')
@section('title', 'Crear perfil')
@section('description', 'Registra tu restaurante en Foodies y atrae a nuevos clientes a tu negocio.')

@section('contenido-formulario')

    <div class="contenedor-registro-restaurante">
        <div class="titulo-formulario-restaurante">
            <h1>Creación de perfil - 2 parte</h1>
            <div class="indice">
                <div class="pagina 1">
                    <p>2/2</p>
                </div>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" data-turbo="false">
            @csrf
            <div class="grid ">
                <h3>Datos de contacto</h3>
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Número de contacto </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Tacos XtremeFusion" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="nombre">Dirección </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Tacos XtremeFusion" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="nombre">Repite la dirección </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Tacos XtremeFusion" required>
                    </div>
                </div>
                <div class="column">
                    <div class="contenedor-formulario select-content">
                        <label for="comunidad-autonoma">Comunidad Autónoma: </label>
                        <select name="comunidad-autonoma" id="comunidad-autonoma">
                            <option value="">Seleccione su Comunidad</option>
                            {{--@foreach ($regions as $region)
                                <option value="{{ $region->id }}">{{ $region->nombre }}</option>
                            @endforeach --}} 
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
            </div>
            <div class="button-formulario parte-2">
                <button class="button-restaurantes-formulario" type="submit">Volver atrás</button>
                <button class="button-restaurantes-formulario" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
    
@endsection
