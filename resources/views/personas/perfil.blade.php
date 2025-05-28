@extends('layouts.layout-perfil')
@section('title', 'Perfil')
@section('description', 'Configura tu perfil y conecta con otras personas.')
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