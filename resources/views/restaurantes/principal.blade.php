@extends('layouts.rest-menu-panel')
@section('title', 'Principal')
@section('description', 'Únete a la comunidad de apasionados por la cocina. Comparte tus platos, sigue a otros foodies y vive la experiencia gastronómica online.')
@section('icono-ajustes', route('ajustes.restaurante'))
@section('icono-logout', route('logout.restaurant'))


@section('content')
    @if(Auth::guard('restaurant')->check())
        Bienvenido {{ Auth::guard('restaurant')->user()->email }}
    @endif
@endsection