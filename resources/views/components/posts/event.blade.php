<div class="evento-card">

    {{-- Encabezado del post--}}
    {{-- Comprobación del tipo de usuario para redirección según el rol --}}
    @php
        $rutaEdicion= route('evento.edit', $evento);
        $rutaEliminacion = route('evento.destroy', $evento);
    @endphp

    {{-- Pasar datos al componente--}}
    <x-posts.header-post 
        :post="$post" 
        :ruta-edicion="$rutaEdicion" 
        :ruta-eliminacion="$rutaEliminacion" 
    />
    <div class="event-structure">
        <div class="row r1">
            <h2>Evento culinario</h2>
        </div>
        <div class="row r2">
            <div class="evento-imagen">
                <a class="link-restaurante-eventos" href=" {{ get_profile_route($evento->restaurant->profile) }}"><img src="{{ optional($evento->restaurant->profile->profilePhoto)->url ?? asset('images/default_image_profile.png') }}" alt="Foto del restaurante"></a>
            </div>
            <div class="evento-detalles">
                <h3 class="evento-titulo">{{ $evento->title }}</h3>
                <p><strong>Cupos disponibles:</strong> {{ $evento->max_participants - $evento->participations->count() }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($evento->event_date)->format('d - m - Y') }}</p>
                <p><strong>Hora encuentro:</strong> {{ \Carbon\Carbon::parse($evento->event_time)->format('H:i') }}</p>
                <strong>Locación:</strong><a class="link-restaurante-eventos" href=" {{ get_profile_route($evento->restaurant->profile) }}"><p>{{ $evento->restaurant->name }}</p></a>
                <p class="evento-descripcion">{{ $evento->short_description }}</p>

                @php
                    $perfil = auth('user')->user()?->profile;
                    $persona = $perfil?->person;
                @endphp

                @if ($persona && $post->profile_id !== $perfil->id)
                @php
                    $yaInscrito = $evento->participations->contains('person_id', $persona->id);
                @endphp

                <form method="POST" class="form-unirse-evento" data-event-id="{{ $evento->post_id }}" data-is-joined="{{ $yaInscrito ? 'true' : 'false' }}">
                    @csrf
                    <button type="button" class="btn-unirse">
                        {{ $yaInscrito ? 'Descartar' : 'Unirse' }}
                    </button>
                </form>
                @endif
            </div>
        </div>   
    </div>
    
    {{-- Footer del post--}}
    {{-- Likes y comentarios --}}
    @php
        $esRestaurante = auth('restaurant')->check();
        $rutaComentarios= $esRestaurante ? route('comments.restaurant', $post) : route('comments.user', $post);
    @endphp

    {{-- Pasar datos al componente--}}
    <x-posts.footer-post
        :post="$post"
        :ruta-comentarios="$rutaComentarios"
    />
</div>