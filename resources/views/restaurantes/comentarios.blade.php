@extends('layouts.rest-menu-panel')
@section('title', 'Comentarios')
@section('description', 'Deja tu opinión en comentarios, hazle saber a los demás lo que piensas.')
@section('content')
    @include('partials.comments', ['post' => $post])
@endsection