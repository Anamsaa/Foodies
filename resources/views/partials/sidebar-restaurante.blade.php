<div class="menu-hamburguesa">
        <button id="boton-hamburguesa" class="btn-menu" aria-label="Abrir menú">
            <i id="hamburguesa-icon" class="fas fa-bars"></i>
        </button>
        <div class="menu-hamburguesa-ayuda">
            <button id="boton-ajustes" class="btn-menu" aria-label="Abrir ajustes">
                <i id="hamburguesa-ajustes" class="fa-solid fa-gear"></i>
            </button>
            <button id="boton-logout" class="btn-menu" aria-label="Cerrar sesión">
                <i id="hamburguesa-logout" class="fa-solid fa-right-from-bracket"></i>
            </button>
        </div>
</div>

<nav class="sidebar">
    <div class="sidebar-contenidos">
        <div class="logo-foodies">
            <img class="img-logo-foodies" src="{{ asset('/images/logo-foodies.png') }}" alt="Logo foodies">
        </div>
        <ul>
            <li><a href="{{ route('dashboard.restaurant') }}" class="{{ request()->routeIs('principal') ? 'activo' : '' }}">Principal</a></li>
            <li><a href="{{ route('perfil.restaurante') }}" class="{{ request()->routeIs('perfil') ? 'activo' : '' }}">Perfil</a></li>
        </ul>
    </div>
    <div class="sidebar-parametros">
        <ul>
            <li><a href="{{ route('ajustes.restaurante') }}">Ajustes</a></li>
            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-rest').submit();">Cerrar Sesión</a></li>
        </ul>
    </div>
</nav>
