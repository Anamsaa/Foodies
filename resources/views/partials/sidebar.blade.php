<div class="menu-hamburguesa">
        <button id="boton-hamburguesa" class="btn-menu" aria-label="Abrir menú">
            <i id="hamburguesa-icon" class="fas fa-bars"></i>
        </button>
        <div class="menu-hamburguesa-ayuda">
            <button id="boton-ajustes" class="btn-menu" aria-label="Abrir ajustes">
                <a href="{{ route('ajustes.user') }}"><i id="hamburguesa-ajustes" class="fa-solid fa-gear"></i></a>
            </button>
            <button id="boton-logout" class="btn-menu" aria-label="Cerrar sesión">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i id="hamburguesa-logout" class="fa-solid fa-right-from-bracket"></i></a>
            </button>
        </div>
</div>

<nav class="sidebar">
    <div class="sidebar-contenidos">
        <div class="logo-foodies">
            <img class="img-logo-foodies" src="{{ asset('/images/logo-foodies.png') }}" alt="Logo foodies">
        </div>
        <ul>
            <li><a href="{{ route('dashboard.user') }}" class="{{ request()->routeIs('principal') ? 'activo' : '' }}">Principal</a></li>
            <li><a href="{{ route('perfil.user')}}">Perfil</a></li>
            <li><a href="{{ route('eventos.index') }}" class="{{ request()->routeIs('eventos') ? 'activo' : '' }}">Eventos Culinarios</a></li>
            <li><a href="{{ route('seguidos.user') }}" class="{{ request()->routeIs('seguidos') ? 'activo' : '' }}">Seguidos</a></li>
            <li><a href="{{ route('red.user') }}" class="{{ request()->routeIs('red') ? 'activo' : '' }}">Red de Sabores</a></li>
        </ul>
    </div>
    <div class="sidebar-parametros">
        <ul>
            <li><a href="{{ route('ajustes.user') }}">Ajustes</a></li>
            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
