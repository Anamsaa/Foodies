@extends('layouts.layout-menu-panel')
@section('title', 'Crear Evento')
@section('description', 'Los eventos culinarios son la nueva forma de conocer personas, ¿Qué esperas para aventurarte a conocer a otros?')
@section('content')
    <div class="form-event-main post-styles">
        <form action="{{ route('evento.store') }}" method="POST" enctype="multipart/form-data" id="form-crear-evento">
            @csrf

            <div class="encabezado-form-post">
                <h2 class="titulo-reviww-post">Crear un nuevo evento</h2>
                <div class="icon-elipsis-form-post">
                     <i class="fa-solid fa-ellipsis"></i>
                </div>  
            </div>

            {{-- Verficación de errores--}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row r1">
                <div class="column-row">
                    <label for="evento-title">Ingresa el título del evento:</label>
                    <input type="text" id="evento-title" name="experience-title" value="{{ old('experience-title') }}" required>
                </div>
                <div class="column-row">
                    <label for="cupos-participacion">Cupos máximos:</label>
                    <input type="number" id="cupos-participacion" name="max_participants" min="1" max="20" value="{{ old('max_participants') }}" required>
                </div>
            </div>
            <div class="row r2">
                <div class="column-row">
                    <label for="hora-encuentro">Hora del encuentro:</label>
                    <input type="time" id="hora-encuentro" name="event_time" value="{{ old('event_time') }}" required>
                </div>
                <div class="column-row">
                    <label for="fecha-encuentro">Fecha encuentro:</label>
                    <input type="date" id="fecha-encuentro" name="event_date" value="{{ old('event_date') }}" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="column-row">
                    <div class="contenedor-formulario select-content">
                        <label for="restaurant-option">Escoge el restaurante anfitrión del encuentro: </label>
                            <select name="restaurant-option" id="restaurant-option">
                                @if($restaurantesLocales->isEmpty())
                                    <option value="">No hay restaurantes en tu provincia</option>
                                @else
                                    <option value="">Seleccione el restaurante</option>
                                    @foreach($restaurantesLocales as $restaurante)
                                        <option value="{{ $restaurante->id }}" {{ old('restaurant-option') == $restaurante->id ? 'selected' : '' }}>
                                        {{ $restaurante->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        <i class="fa-solid fa-caret-down"></i>
                    </div>
                </div>
            </div>
            <div class="row r3">
                <div class="column-row">
                    <label for="invitacion">Da una breve descripción del evento: </label>
                    <textarea name="invitacion" id="invitacion" rows="8" cols="50" placeholder="Ej: 'Quiero conocer este nuevo restaurante colombiano en el centro de Madrid ¿Me acompañas?">{{ old('invitacion', session('restaurant_step1.invitacion')) }}</textarea>
                </div>  
            </div>    
            <button type="submit">Guardar</button>
        </form>
    </div> 
@endsection

