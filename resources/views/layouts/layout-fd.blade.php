<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Foodies')</title>
    <meta name="description" content="@yield('description', 'Social Network for foodies')">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-favicon.png') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
   @include('partials.sidebar')
   <main>
    @yield('content')
   </main>
</body>
</html>