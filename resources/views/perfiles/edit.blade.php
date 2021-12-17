@extends('layouts.app')

{{-- Cargando la hoja de estilos de trix --}}
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

{{-- creando botones para redirigir --}}
@section('botones')

    {{-- Boton para regresar al administrador de recetas --}}
     <a  href="{{route('recetas.index')}}" class="btn btn-outline-success mr-2 text-uppercsae font-weight-bold">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
          </svg>
        Regresar al menu
    </a>
@endsection

{{-- Desarrollando un formulario para ediar perfil --}}
@section('content')
    {{-- {{$perfil}} --}}
    <h1 class="text-center">Editar Mi Perfil</h1>
    <div class="row justify-content-center mt-5">
        <div class="col-md-10 bg-white p-3">
            <form action="{{route('perfiles.update', ['perfil' => $perfil->id] ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                {{-- Modificar el nombre de usuario --}}
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control @error ('nombre') is-invalid @enderror " id="nombre" placeholder="Tu Nombre" value="{{$perfil->usuario->name}}">
                    @error('nombre')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Modificar la url --}}
                <div class="form-group">
                    <label for="url">Sitio Web</label>
                    <input type="text" name="url" class="form-control @error ('url') is-invalid @enderror " id="url" placeholder="Tu url" value="{{$perfil->usuario->url}}">
                    @error('url')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Modificar biografia del perfil --}}
                <div class="form-group mt-3">
                    <label for="biografia">Biografia</label>
                    <input id="biografia" type="hidden" name="biografia" value="{{$perfil->biografia}}">
                    {{-- Agregando el editor de trix --}}
                    <trix-editor input="biografia" class="form-control @error('biografia') is-invalid @enderror"></trix-editor>
                    @error('biografia')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Imagen --}}
                <div class="form-group mt-3">
                    <label for="imagen">Tu imagen </label>
                    <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen">
                    @if( $perfil->imagen )
                        <div class="mt-4">
                            <p>Imagen Actual:</p>
                            <img src="/storage/{{$perfil->imagen}}" style="width: 300px">
                        </div>
                        @error('imagen')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    @endif
                </div>

                {{-- Boton de Actualizar perfil --}}
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Actualizar perfil">
                </div>

            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection