<div class="comment-container">

    {{-- Caja para dejar comentarios --}}
    <div class="comment-box">
        <form action="{{ route('post.comment', $post->id) }}" method="POST">
            @csrf
            <textarea name="content" id="comentarios-text-area" placeholder="Escribe tu comentario aquí..." rows="8" cols="50"></textarea>
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
                            <a href="{{  get_profile_route($comment->profile) }}">
                                <img src="{{ optional($comment->profile->profilePhoto)->url ?? asset('images/default_image_profile.png')}}" alt="Avatar">
                            </a>

                            <div class="content-properties">
                                <a href="{{  get_profile_route($comment->profile) }}">
                                    <p class="name-account">{{ $comment->profile->restaurant->name 
                                        ?? $comment->profile->person->first_name . ' ' . $comment->profile->person->last_name 
                                        ?? 'Anónimo' }}
                                    </p>
                                </a>
                                <p class="time">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>

                            {{-- Verificar que el usuario sea propietario del comentario para darle permisos de eliminación de comentarios --}}
                            @php
                                $authProfile = auth('user')->user()?->profile ?? auth('restaurant')->user()?->profile;
                                $esPropietario = $authProfile && $authProfile->id === $comment->profile_id;
                            @endphp
                        
                            @if ($esPropietario)
                                <div class="post-options">
                                    <div class="icon-elipsis" onclick="toggleMenu(this)">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </div>  
                                    <div class="elipsis-mmenu">
                                        <form action="{{ route('comment.delete', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                        {{-- Cuerpo del comentario --}}
                        <div class="content"> 
                            <p class="text-comment">{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <p>Se el primer foodie en comentar</p>
                @endforelse
        </div>  
    </div>
</div> 

