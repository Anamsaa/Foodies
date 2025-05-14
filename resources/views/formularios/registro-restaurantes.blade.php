@extends('layouts.formulario.layout-formulario')
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
        <form action="" method="POST" enctype="multipart/form-data" data-turbo="false">
            @csrf
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
                        <div class="choose-days">
                            <input type="checkbox" id="lunes" name="lunes" value="Lunes">
                            <label for="lunes">Lunes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="martes" name="martes" value="Martes">
                            <label for="martes">Martes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="miercoles" name="miercoles" value="Miércoles">
                            <label for="miercoles">Miércoles</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="jueves" name="jueves" value="Jueves">
                            <label for="jueves">Jueves</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="viernes" name="viernes" value="Viernes">
                            <label for="viernes">Viernes</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="sabado" name="sabado" value="Sábado">
                            <label for="sabado">Sábado</label>
                        </div>
                        <div class="choose-days">
                            <input type="checkbox" id="domingo" name="domingo" value="Domingo">
                            <label for="domingo">Domingo</label>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="contenedor-formulario">
                        <label for="link-restaurante">Link de tu web oficial: </label>
                        <input type="text" id="link-restaurante" name="link-restaurante" placeholder="Ej: www.mirestaurante.es">
                    </div>

                    <div class="contenedor-formulario select-content">
                        <label for="tipo-restaurante">Elige el tipo de restaurante: </label>
                        <select name="tipo" id="tipo">
                            <option value=""></option>
                        </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                    <div class="contenedor-formulario">
                        <label for="invitacion">Invita a los foodies a tu negocio: </label>
                        <textarea name="invitacion" id="invitacion" rows="6" cols="50" placeholder="Ej: '¡Bienvenido a nuestro restaurante! Aquí nuestra especialidad son los tacos al Pastor"></textarea>
                    </div>

                    <div class="contenedor-imagenes">
                        <div class="contenedor-formulario cargar-imagenes">
                            <span class="titulo-imagen">Escoge una foto de perfil</span>
                            <label for="imagen-perfil" class="upload-box" id="drop-area">
                                <i class="fa-solid fa-plus"></i>
                                <span>Arrastra una imagen o haz click</span>
                                <input type="file" name="imagen-perfil" id="imagen-perfil" accept=".jpg, .jpeg, .png, .webp">
                            </label>
                        </div>
                        <div class="contenedor-formulario cargar-imagenes">
                            <span class="titulo-imagen">Escoge una foto de portada</span>
                            <label for="imagen-portada" class="upload-box" id="drop-area-portada">
                                <i class="fa-solid fa-plus"></i>
                                <span>Arrastra una imagen o haz click</span>
                                <input type="file" name="imagen-portada" id="imagen-portada" accept=".jpg, .jpeg, .png, .webp">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-formulario">
                <button class="button-restaurantes-formulario" type="submit">Siguiente</button>
            </div>
        </form>
    </div>
    
@endsection
