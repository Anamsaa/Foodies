<div class="comment-container">

    {{-- Caja para dejar comentarios --}}
    <div class="comment-box">
        <form action="{{ route('post.comment', $post->id) }}" method="POST">
            @csfr
            <textarea name="comentarios-text-area" id="comentarios-text-area" placeholder="Escribe tu comentario aquí..." rows="8" cols="50"></textarea>
            <button type="submit">Comentar</button>
        </form>
    </div>

    <hr>

    {{-- LISTA DE COMENTARIOS DE RESPUESTA EN CADA POST --}}
    <div class="comment-list">
        <h3>Comentarios</h3>

        <div class="comments" id="comments">
                {{-- Espacio para mostrar los otros comentarios --}}
                @forelse($post->comments as $comment)
                
                    {{-- Estructura de cada comentario --}}
                    <div class="comment-line">
                        <div class="header-comment">
                            <a href="{{ $perfilRoute }}">
                                <img src="{{ optional($comment->profile->profilePhoto)->url ?? asset('images/default_image_profile.png')}}" alt="Avatar">
                            </a>

                            <div class="content-properties">
                                <a href="{{ $perfilRoute }}"><p class="name-account"></p></a>
                                <p class="time"></p>
                            </div>

                            {{-- Si es propietario tener opciones de eliminación y edición de cada comentario que haga --}}
                            @php
                                $propietario = (Auth::guard('user')->check() && Auth::guard('user')->user()->profile->id === $post->profile_id) ||
                                        (Auth::guard('restaurant')->check() && Auth::guard('restaurant')->user()->profile->id === $post->profile_id);

                                $esRestaurante = Auth::guard('restaurant')->check();

                                $rutaEdicion = $esRestaurante ? route('post.edit.restaurant', $post) : route('post.edit', $post);
                                $rutaEliminacion = $esRestaurante ? route('post.destroy.restaurant', $post) : route('post.destroy', $post);
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
                    
                        <div class="content"> 
                            <p class="text-comment">{{ $comment->content }}</p>
                        </div>
                    </div>
        </div>
    </div>
</div> 

