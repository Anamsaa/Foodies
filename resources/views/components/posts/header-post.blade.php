{{-- Encabezado del post--}
{{-- Declaración de variables que recibirá el componente--}}
@props(['post', 'rutaEdicion', 'rutaEliminacion'])

<div class="post-header">
    <div class="autor-info">
        <a href="{{ get_profile_route($post->profile) }}">
            <img class="post-avatar" src="{{ optional($post->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Avatar usuario">
        </a>
        <div class="autor-meta">
            <a href="{{ get_profile_route($post->profile)}}">
                <p class="user-name">
                    {{ $post->profile->restaurant->name 
                    ?? ($post->profile->person->first_name . ' ' . $post->profile->person->last_name) 
                    ?? 'Anónimo' }}
                </p>
            </a>

             {{-- Utilizo el método de la librería Carbon, para devolver una descripción relativa --}}
            <span class="user-post-time">{{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>

    @php
        $authProfile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile;
        $propietario = $authProfile && $authProfile->id === $post->profile_id;
    @endphp

    {{-- Opciones de edición y eliminación de posts solo para usuarios propietarios --}}
    @if ($propietario)
        <div class="post-options">
            <div class="icon-elipsis" data-toggle-menu>
                <i class="fa-solid fa-ellipsis"></i>
            </div>  
            <div class="elipsis-menu" data-menu>
                {{-- Comprobar que ambas variables existen--}}
                @isset($rutaEdicion)
                {{-- Parámetros $slot para cambiar la ruta según el tipo de usuario y de publicación --}}
                    <a href="{{ $rutaEdicion }}">Editar</a>
                @endisset

                @isset($rutaEliminacion)
                    <form action="{{ $rutaEliminacion}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                @endisset
            </div>
        </div>
    @endif
</div>
