 {{-- Footer del post--}}

 @props(['post', 'rutaComentarios'])

<div class="post-footer">
    {{-- Icon para dar like a una publicación --}}
    <div class="post-like icons-footer">
        <button class="btn-like"
            data-post-id="{{ $post->id }}"
            data-liked="{{ $post->likes->contains('profile_id', auth('user')->user()?->profile->id ?? auth('restaurant')->user()?->profile->id ?? null) ? 'true' : 'false' }}">
            <i class="fa-solid fa-heart {{ $post->likes->contains('profile_id', auth('user')->user()?->profile->id ?? auth('restaurant')->user()?->profile->id ?? null) ? 'liked' : '' }}"></i>
            <span class="like-count">{{ $post->likes->count() }}</span>
        </button>
    </div>

    {{-- Redirección a comentarios --}}
    <div class="post-comment icons-footer">
        @isset($rutaComentarios)
            <a href="{{ $rutaComentarios }}" class="container-comments-box">
                <i class="fa-solid fa-comment"></i>
                <span>{{ $post->comments->count() }}</span>
            </a>

            {{-- Si no existe la ruta a comentarios, se muestra de todas maneras el conteo y el icono --}}
        @else
            <i class="fa-solid fa-comment"></i>
            <span>{{ $post->comments->count() }}</span>
        @endisset
    </div>
</div>