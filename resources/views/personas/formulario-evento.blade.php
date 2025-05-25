@extends('layouts.layout-menu-panel')
@section('title', 'Crear Evento')
@section('description', 'Los eventos culinarios son la nueva forma de conocer personas, ¿Qué esperas para aventurarte a conocer a otros?')
@section('content')
    <div class="form-event-main post-styles">
        <form action="">
            <div class="encabezado-form-post">
                <h2 class="titulo-reviww-post">Crear un nuevo evento</h2>
                <div class="icon-elipsis-form-post">
                     <i class="fa-solid fa-ellipsis"></i>
                </div>  
            </div>
            <div class="row r1">
                <div class="column-row">
                    <label for="evento-title">Ingresa el título del evento:</label>
                    <input type="text" id="evento-title" name="evento-title">
                </div>
                <div class="column-row">
                    <label for="evento-title">Ingresa el título del evento:</label>
                    <input type="text" id="evento-title" name="evento-title">
                </div>
            </div>
            <div class="row r2">
                <dive class="column-row">
                    <label for="hora-encuentro">Hora del encuentro:</label>
                    <input type="time" id="hora-encuentro" name="hora-encuentro">
                </dive>
                 <div class="column-row">
                    <label for="fecha-encuentro">Fecha encuentro:</label>
                    <input type="date" id="fecha-encuentro" name="fecha-encuentro">
                </div>
                <div class="column-row">
                    <div class="contenedor-formulario select-content">
                        <label for="restaurant-option">Escoge el restaurante anfitrión del encuentro: </label>
                            <select name="restaurant-option" id="restaurant-option">
                            <option value="">Seleccione el restaurante</option>
                            </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
            </div>
            <div class="row r3">
                <div class="column-row">
                    <label for="descripcion-evento">Da una breve descripción del evento: </label>
                    <textarea name="invitacion" id="invitacion" rows="8" cols="50" placeholder="Ej: '¡Bienvenido a nuestro restaurante! Aquí nuestra especialidad son los tacos al Pastor">{{ old('invitacion', session('restaurant_step1.invitacion')) }}</textarea>
                </div>  
            </div>    
        </form>
        <button type="submit">Guardar</button>
    </div> 
@endsection

