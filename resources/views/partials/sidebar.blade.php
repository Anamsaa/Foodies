<nav class="sidebar">
    <div class="sidebar-contenidos">
        <div class="logo-foodies">
            <img class="img-logo-foodies" src="{{ asset('/images/logo-foodies.png') }}" alt="Logo foodies">
        </div>
        <ul>
            <li><a href="{{ route('principal') }}" class="{{ request()->routeIs('principal') ? 'activo' : '' }}">Principal</a></li>
            <li><a href="{{ route('perfil') }}" class="{{ request()->routeIs('perfil') ? 'activo' : '' }}">Perfil</a></li>
            <li><a href="{{ route('eventos') }}" class="{{ request()->routeIs('eventos') ? 'activo' : '' }}">Eventos Culinarios</a></li>
            <li><a href="{{ route('seguidos') }}" class="{{ request()->routeIs('seguidos') ? 'activo' : '' }}">Seguidos</a></li>
            <li><a href="{{ route('red') }}" class="{{ request()->routeIs('red') ? 'activo' : '' }}">Red de Sabores</a></li>
        </ul>
    </div>
    <div class="sidebar-parametros">
        <ul>
            <li><a href="/ajustes">Ajustes</a></li>
            <li><a href="/log-out">Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
