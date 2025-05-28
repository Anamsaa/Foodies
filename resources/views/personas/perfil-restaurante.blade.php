@extends('layouts.layout-ajena-persona')
@section('title', 'Perfil restaurante')
@section('description', 'Explora perfiles de restaurantes en Foodies')
@section('content')
    @forelse($posts as $post)
        @include ('components.posts.post', ['post' => $post])
        @empty
        <p class="no-post-message">No hay publicaciones todavía.</p>
    @endforelse 
@endsection