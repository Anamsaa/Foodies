@extends('layouts.rest-menu-panel')
@section('title', 'Subir publicación')
@section('description', ' Crear publicaciones permitirá que otros foodies te conozcan, anímate a compartir lo que piensas')
@section('content')
    <div class="form-post-main">
        <form action="{{ isset($post) ? route('post.update', $post) : route('post.store') }}" method="post" id="form-post" enctype="multipart/form-data" id="form-post">
            @csrf
            @if (isset($post))
                @method('PUT')
            @endif

            <div class="encabezado-form-post">
                <h2 class="titulo-reviww-post">Redactar publicación</h2>
            </div>
            <div class="container-texto-publicacion">
                <label for="texto-publicacion-post">¿En qué estás pensando hoy? </label>
                <textarea name="texto-publicacion-post" id="texto-publicacion-post" rows="8" cols="50" 
                placeholder="Comenta brevemente lo qué estás pensando hoy..">{{ old('texto-publicacion-post', $post->content ?? '') }}</textarea>
            </div>  
           
            <div class="contenedor-formulario cargar-imagenes">
                <span class="titulo-imagen">Quieres añadir una foto a tu publicación: </span>

                <p class="advice">*Recuerda que si no quieres subir ninguna imagen, puedes seleccionar "cancelar" al cargar la imagen*</p>
                
                <label for="imagen-post-regular" class="styles-contenedor-imagen">
                    <i class="fa-solid fa-plus"></i>
                    <span class="file-label-text" id="file-label-text">Haz click para seleccionar una imagen</span>
                </label>
                <input id="imagen-post-regular" name="imagen-post-regular" type="file" style="display: none;">
            </div>
            <button type="submit">
                {{ isset($post) ? 'Actualizar publicación' : 'Publicar' }}
            </button>
        </form>
    </div> 
@endsection

{{-- ** NOTAS ** --}}
{{-- Visualización desde la interfaz de un restaurante de la subida de posts --}}