@extends('layouts.app')

{{-- creando botones para redirigir --}}
@section('botones')

    {{-- Boton para regresar al administrador de recetas --}}
    <a  href="{{route('recetas.index')}}" class="btn btn-outline-info mr-2 text-uppercsae font-weight-bold">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        Regresar al menu
    </a>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-5">
                @if($perfil->imagen)
                    <img src="/storage/{{$perfil->imagen}}" class="w-100 rounded-circle" alt="Imagen perfil">
                @endif
            </div>
            <div class="col-md-7 mt-5 mt-md-0">
                <h2 class="text-center mb-2 text-primary">{{$perfil->usuario->name}}</h2>
                <a href="{{$perfil->usuario->url}}">Visitar Sitio Web</a>
                <div class="biografia">
                    {!! $perfil->biografia !!}
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-center my-5">Recetas Creadas por: {{$perfil->usuario->name}}</h2>
    <div class="container">
        <div class="row mx-auto bg-white p-4">
            @if(count($recetas) > 0)
                @foreach($recetas as $receta )
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            {{-- Obteniendo la imagen de la receta --}}
                            <img src="/storage/{{$receta->imagen}}" class="card-img-top" alt="Imagen receta">
                            {{-- Titulo y link de la receta --}}
                            <div class="card-body">
                                <h1>{{$receta->titulo}}</h1>
                                <a href="{{route('recetas.show', ['receta' => $receta->id ])}}" class="btn btn-primary d-block mt-4 text-uppercase font-weight-bold">Ver Receta</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center w-100">No hay recetas aún...</p>
            @endif
            <div class="col-12 mt-4 justify-content-center d-flex">
                {{ $recetas->links() }}
           </div>
        </div>
    </div>

@endsection