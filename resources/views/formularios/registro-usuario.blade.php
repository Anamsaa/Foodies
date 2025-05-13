@extends('layouts.formulario.layout-formulario')
@section('title', 'Crear perfil')
@section('description', 'Regístrate en Foodies donde puedes compartir tus platos favoritos y conectar con amantes de la gastronomía como tú.')

@section('contenido-formulario')

    <div class="contenedor-registro-usuario">
        <div class="titulo-formulario-usuario">
            <h1>Creación de perfil</h1>
        </div>
        <form action="">
            <div class="grid">
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombres: </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Julian" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="apellidos">Apellidos: </label>
                        <input type="text" id="apellidos" name="apellidos" placeholder="Ej: Moreno" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="fnacimiento">Fecha de nacimiento: </label>
                        <input type="date" id="fnacimiento" name="fnacimiento" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="pais">País: </label>
                        <select name="pais" id="pais">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="region">Región: </label>
                        <select name="region" id="region">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="ciudad">Ciudad: </label>
                        <select name="region" id="region">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="comida">Escribe las 3 comidas que más te gusten: </label>
                        <div class="comidas-favoritas">
                            <input type="text" id="comida1" name="comida" required>
                            <input type="text" id="comida2" name="comida" required>
                            <input type="text" id="comida3" name="comida" required>
                        </div>
                    </div>  
                    <div class="contenedor-formulario">
                        <label for="descripcion-usuario">Da una breve descripción de ti</label>
                        <textarea name="descripcion-usuario" id="descripcion-usuario" rows="6" cols="50"></textarea>
                    </div>  

                    <div class="contenedor-imagenes">
                        <div class="contenedor-formulario">
                            <label for="imagen-perfil">Escoge una foto de perfil</label>
                            <input type="file" name="imagen-perfil">
                        </div>
                        <div class="contenedor-formulario">
                            <label for="imagen-portada">Escoge una foto de portada</label>
                            <input type="file" name="imagen-portada">
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-usuarios-formulario" type="submit">Cargar perfil</button>
            </div>
        </form>
    </div>
    
@endsection
