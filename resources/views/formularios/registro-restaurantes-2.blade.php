@extends('layouts.formulario.layout-formulario')
@section('title', 'Crear perfil')
@section('description', 'Registra tu restaurante en Foodies y atrae a nuevos clientes a tu negocio.')

@section('contenido-formulario')

    <div class="contenedor-registro-restaurante">
        <div class="titulo-formulario-restaurante">
            <h1>Creación de perfil - restaurantes</h1>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" data-turbo="false">
            <div class="grid">
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="nombre">Nombre del establecimiento </label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej: Tacos XtremeFusion" required>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="horarios">Comenta brevemente los horarios que maneja tu negocio: </label>
                        <textarea name="horarios" id="horarios" rows="6" cols="50" placeholder="Ej: Jueves y Viernes 18:00 a 22:00 | Domingos y Sábados de 18:00 a 23:00"></textarea>
                    </div>
                    <div class="contenedor-formulario">
                        <p>Días de apertura:</p>
                        <input type="checkbox" id="lunes" name="lunes" value="Lunes">
                        <label for="lunes">Lunes</label><br>
                        <input type="checkbox" id="martes" name="martes" value="Martes">
                        <label for="martes">Martes</label><br>
                        <input type="checkbox" id="miercoles" name="miercoles" value="Miércoles">
                        <label for="miercoles">Miércoles</label>
                        <input type="checkbox" id="jueves" name="jueves" value="Jueves">
                        <label for="jueves">Jueves</label><br>
                        <input type="checkbox" id="viernes" name="viernes" value="Viernes">
                        <label for="viernes">Viernes</label><br>
                        <input type="checkbox" id="sabado" name="sabado" value="Sábado">
                        <label for="sabado">Sábado</label>
                        <input type="checkbox" id="domingo" name="domingo" value="Domingo">
                        <label for="domingo">Domingo</label>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="link-restaurante">Link de tu web oficial: </label>
                        <input type="text" id="link-restaurante" name="link-restaurante" placeholder="Ej: www.mirestaurante.es">
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
                        <label for="descripcion-restaurante">Da una breve descripción de ti</label>
                        <textarea name="descripcion-restaurante" id="descripcion-restaurante" rows="6" cols="50"></textarea>
                    </div>  

                    <div class="contenedor-imagenes">
                        <div class="contenedor-formulario">
                            <label for="imagen-perfil">Escoge una foto de perfil</label>
                            <div class="upload-imagenes">
                                <input type="file" name="imagen-perfil">
                            </div>    
                        </div>
                        <div class="contenedor-formulario">
                            <label for="imagen-portada">Escoge una foto de portada</label>
                            <div class="upload-imagenes">
                                <input type="file" name="imagen-portada">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-restaurantes-formulario" type="submit">Cargar perfil</button>
            </div>
        </form>
    </div>
    
@endsection
