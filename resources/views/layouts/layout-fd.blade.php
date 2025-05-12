<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Fuentes --}}
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Foodies')</title>
    <meta name="description" content="@yield('description', 'Social Network for foodies')">
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo-favicon.png') }}">
    {{-- Habilitar Turbo en todas las vistas --}}
    <script type="module" src="{{ asset('js/turbo.js') }}" defer></script>
</head>
<body>
    <div class="componentes-principales">
        @include('partials.sidebar')
        <main>
            <div class="panel-de-control">
                <div class="panel-control-ayuda">
                    <button id="panel-control-ajustes" class="btn-panel" aria-label="Abrir ajustes">
                        <i id="panel-ajustes" class="fa-solid fa-gear"></i>
                    </button>
                    <button id="panel-control-logout" class="btn-panel" aria-label="Cerrar sesión">
                        <i id="panel-logout" class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </div>
            </div>
            <div class="contenidos">
                <turbo-frame id="page-content">

                    <p>Hola estoy probando
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod, sapien non vestibulum luctus, urna elit fermentum quam, ut pretium purus nulla sed nunc. Duis fermentum tellus at ante accumsan, at hendrerit justo ultricies. Proin nec lacus a leo tristique tincidunt. Vestibulum feugiat luctus justo, in tristique sapien mattis nec. Nullam ut diam vitae turpis faucibus blandit in id metus. Curabitur in pulvinar turpis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Integer accumsan augue sed nisl sollicitudin, nec feugiat mi scelerisque. Pellentesque ut turpis id lorem lacinia convallis. Curabitur vulputate imperdiet facilisis. Etiam euismod ex ut arcu tincidunt, a gravida purus tincidunt. Fusce a arcu ex. Nam sodales, metus in euismod tristique, ligula justo scelerisque erat, nec mattis arcu nisi non turpis. Sed tincidunt accumsan purus, nec fermentum erat congue a.

Aliquam erat volutpat. Suspendisse tincidunt imperdiet risus, vel consequat velit ultrices ac. Fusce quis justo sed lacus luctus facilisis. Cras vitae gravida tortor. Proin ultrices sem at purus vehicula, nec feugiat nisi vestibulum. Aenean rhoncus orci a nulla eleifend, at tincidunt metus cursus. Nulla blandit accumsan ipsum, vitae dictum elit tempor et. Nam facilisis ante nec arcu placerat, id varius odio sollicitudin.

Vivamus convallis metus sapien, a fringilla magna rhoncus sed. Integer a eros vitae risus porta sollicitudin at at nulla. Sed lobortis erat sed nisi euismod, sit amet fermentum justo vehicula. Sed commodo leo sed est pharetra, ac dignissim purus iaculis. Cras fermentum blandit lacus. Duis porttitor felis quis velit bibendum scelerisque. Sed imperdiet ante et dolor accumsan, nec suscipit arcu ullamcorper.

Nunc vel arcu laoreet, lobortis mi at, efficitur diam. Vestibulum in ex a orci porta lacinia. Nulla vitae velit eget turpis ultrices rutrum nec non metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam eget urna eu risus dignissim facilisis. Curabitur convallis lacinia metus, at gravida dolor finibus non. Morbi nec est convallis, tincidunt est nec, tincidunt nulla. Mauris nec ultrices nisl. Integer suscipit sapien ut urna dapibus lacinia.

Morbi id enim vitae sapien eleifend porta. Nulla facilisi. Donec malesuada, sem non congue cursus, mi nulla sodales libero, nec hendrerit lectus orci non ipsum. In hac habitasse platea dictumst. Fusce a fringilla nisi, nec lobortis justo. Donec semper purus sit amet tellus feugiat, nec dapibus nulla finibus. Maecenas aliquam orci a ante dapibus, vel finibus velit convallis. Vivamus faucibus congue mi, nec condimentum justo tristique eget.

                    </p>
                    @yield('content')
                </turbo-frame>
            </div>
        </main>
    </div>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</body>
</html>