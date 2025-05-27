<div class="card-post">
    {{-- Encabezado del post--}}
    {{-- Comprobación del tipo de usuario para redirección según el rol --}}
    @php
        $esRestaurante = auth('restaurant')->check();
        $rutaEdicion= $esRestaurante ? route('post.edit.restaurant', $post) : route('post.edit', $post);
        $rutaEliminacion = $esRestaurante ? route('post.destroy.restaurant', $post) : route('post.destroy', $post);
    @endphp

    {{-- Pasar datos al componente--}}
    <x-posts.header-post 
        :post="$post" 
        :ruta-edicion="$rutaEdicion" 
        :ruta-eliminacion="$rutaEliminacion" 
    />

    {{-- Contenido --}}
    <div class="post-content">
        <p>{{ $post->content }}</p>
        @if ($post->photo)
            <img class="post-image" src="{{ asset($post->photo->url) }}" alt="Foto de publicación">
        @endif
    </div>

    {{-- Footer del post--}}
    {{-- Likes y comentarios --}}
    @php
        $rutaComentarios= $esRestaurante ? route('comments.restaurat', $post) : route('comments.user', $post);
    @endphp

    {{-- Pasar datos al componente--}}
    <x-posts.footer-post
        :post="$post"
        :ruta-comentarios="$rutaComentarios"
    />
</div>