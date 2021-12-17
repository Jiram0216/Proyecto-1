@extends('layouts.app')

{{-- creando botones para redirigir --}}
@section('botones')
     {{-- Boton para regresar al administrador de recetas --}}
     <a  href="{{route('recetas.index')}}" class="btn btn-outline-primary mr-2 text-uppercsae font-weight-bold">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
          </svg>
        Regresar al menu
    </a>
@endsection

@section('content')

        {{-- <h1>{{$receta}}</h1> --}}

    <article class="contenido-receta bg-white p-5 shadow">
        <h1 class="text-center mb-4">{{$receta->titulo}}</h1>
        {{-- Agregando la imagen de la receta --}}
        <div class="imagen-receta">
            <img src="/storage/{{$receta->imagen}}" class="w-100">
        </div>
        {{-- Imprimiendo el contenido de la receta --}}
        <div class="receta-meta mt-5">

            {{-- Categoria de la receta --}}
            <p>
                <span class="font-weight-bold text-primary">Escrito en:</span>
                <a class="text-dark" href="{{route('categorias.show', ['categoriaReceta' => $receta->categoria->id ])}}">{{$receta->categoria->nombre}}</a>
            </p>

            {{-- Fecha de la receta --}}
            <p>
                <span class="font-weight-bold text-primary">Fecha:</span>
                {{-- Obteniendo la fecha mediante codigo php --}}
                @php
                  $fecha = $receta->created_at 
                @endphp
                {{-- Todo: Mostrar la fecha obtenida de php a Vue.js --}}
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>
            </p>

            {{-- Autor  de la receta --}}
            <p>
                <span class="font-weight-bold text-primary">Autor:</span>
                <a class="text-dark" href="{{route('perfiles.show', ['perfil' => $receta->autor->id ])}}">{{$receta->autor->name}}</a>
            </p>

            {{-- Ingredientes de la receta --}}
            <div class="ingredientes">
                <h2 class="my-3 text-primary">Ingredientes:</h2>
                {!! $receta->ingredientes !!}
            </div>

            {{-- Preparacion de la receta --}}
            <div class="Preparacion">
                <h2 class="my-3 text-primary">Preparacion:</h2>
                {!! $receta->Preparacion !!}
            </div>

            {{-- likes --}}
            <div class="justify-content-center row text-center">
                <like-button receta-id="{{$receta->id}}" like="{{$like}}" likes="{{$likes}}"></like-button>
            </div>
            
        </div>
    </article>

@endsection