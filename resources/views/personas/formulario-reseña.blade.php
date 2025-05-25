@extends('layouts.layout-menu-panel')
@section('title', 'Crear Reseña')
@section('description', 'Publica una reseña para que las personas conozcan tu experiencia en restaurantes')
@section('content')
    <div class="form-review-main post-styles">
        <form action="">
            <div class="encabezado-form-post">
                <h2 class="titulo-reviww-post">Escribir reseña</h2>
                <div class="icon-elipsis-form-post">
                     <i class="fa-solid fa-ellipsis"></i>
                </div>  
            </div>
            <div class="row">
                <div class="column-row">
                    <label for="experience-title">Ingresa el título de la experiencia:</label>
                    <input type="text" id="experience-title" name="experience-title">
                </div>
                <div class="column-row">
                    <div class="contenedor-formulario select-content">
                        <label for="puntuacion-review">Puntua del 1 al 10 tu experiencia</label>
                        <select name="puntuacion-review" id="puntuacion-review">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
                <div class="column-row">
                    <div class="contenedor-formulario select-content">
                        <label for="restaurant-option">Elige el restaurante que vas a puntuar: </label>
                        <select name="restaurant-option" id="restaurant-option">
                        <option value="">Seleccione el restaurante</option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <label for="descripcion-evento">Da una breve descripción del evento: </label>
                <textarea name="invitacion" id="invitacion" rows="8" cols="50" placeholder="Ej: '¡Bienvenido a nuestro restaurante! Aquí nuestra especialidad son los tacos al Pastor">{{ old('invitacion', session('restaurant_step1.invitacion')) }}</textarea>
            </div>
            <div class="row">
                <div class="contenedor-formulario cargar-imagenes">
                    <span class="titulo-imagen">Añade una foto para completar tu experiencia: </span>
                    <label for="imagen-review">
                    <i class="fa-solid fa-plus"></i>
                    <span>Haz click para seleccionar una imagen</span>
                    </label>
                    <input id="imagen-review" name="imagen-review" type="file">
                </div>
            </div>  
        </form>
        <button type="submit">Guardar</button>
    </div> 
@endsection
