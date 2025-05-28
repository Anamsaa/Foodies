@extends('layouts.rest-perfil')
@section('title', 'Perfil restaurante')
@section('description', 'Configura tu perfil y conecta con otras personas.')
@section('content')
    @forelse($posts as $post)
        @include ('components.posts.post', ['post' => $post])
     @empty
        <p class="no-post-message">No hay publicaciones todavía.</p>
    @endforelse 
@endsection