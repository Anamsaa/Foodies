@extends('layouts.layout-ajena-restaurante')
@section('title', 'Perfil persona')
@section('description', 'Explora perfiles de otros usuarios en Foodies')
@section('content')
    @forelse($posts as $post)
        @if ($post->post_type === 'Culinary Event' && $post->culinaryEvent)
            @include('components.posts.event', ['post' => $post, 'evento' => $post->culinaryEvent])
        @else
            @include('components.posts.post', ['post' => $post])
        @endif
    @empty
        <p class="no-post-message">No hay publicaciones todavía.</p>
    @endforelse
@endsection