<div class="card-post">

    {{-- Encabezado del post--}}
    <div class="post-header">
        <div class="autor-info">
            <img class="post-avatar" src="{{ optional($post->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar usuario">
            <div class="autor-meta">
                <p class="user-name">{{ $post->profile->restaurant->name 
                                        ?? ($post->profile->person->first_name . ' ' . $post->profile->person->last_name) 
                                        ?? 'Anónimo' }}</p>

                {{-- Utilizo el método de la librería Carbon, para devolver una descripción relativa --}}
                <span class="user-post-time">{{ $post->created_at->diffForHumans() }}</span>
            </div>
        </div>
        
        {{-- Opciones de edición y eliminación de posts solo para usuarios propietarios --}}
        @php
            $propietario = (Auth::guard('user')->check() && Auth::guard('user')->user()->profile->id === $post->profile_id) ||
                        (Auth::guard('restaurant')->check() && Auth::guard('restaurant')->user()->profile->id === $post->profile_id);

            $esRestaurante = Auth::guard('restaurant')->check();

            $rutaEdicion = $esRestaurante ? route('post.edit.restuaurant', $post) : route('post.edit', $post);
            $rutaEliminacion = $esRestaurante ? route('post.destroy.restuaurant', $post) : route('post.destroy', $post);
        @endphp

        @if ($propietario)
            <div class="post-options">
                <div class="icon-elipsis" onclick="toggleMenu(this)">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>  
                <div class="elipsis-mmenu">
                    <a href="{{ $rutaEdicion }}">Editar</a>
                    <form action="{{ $rutaEliminacion }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    {{-- Contenido --}}
    <div class="post-content">
        <p>{{ $post->content }}</p>
        @if ($post->photo)
            {{-- /@dd($post->photo->url) --}}
            <img class="post-image" src="{{ asset($post->photo->url) }}" alt="Foto de publicación">
        @endif
    </div>

    {{-- Likes y comentarios --}}
    <div class="post-footer">
        <div class="post-like icons-footer">
            <i class="fa-solid fa-heart"></i>
            <span>{{ $post->likes->count() }}</span>
        </div>
        <div class="post-comment icons-footer">
            <i class="fa-solid fa-comment"></i>
            <span>{{ $post->comments->count() }}</span>
        </div>
    </div>
</div>