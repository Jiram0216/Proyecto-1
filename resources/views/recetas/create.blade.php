{{-- Extendiendo desde layout app para usar el diseño --}}
@extends('layouts.app')
{{-- Cargando la hoja de estilos de trix --}}
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css" integrity="sha512-CWdvnJD7uGtuypLLe5rLU3eUAkbzBR3Bm1SFPEaRfvXXI2v2H5Y0057EMTzNuGGRIznt8+128QIDQ8RqmHbAdg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

{{-- creando botones para redirigir --}}
@section('botones')
    {{-- Boton para regresar al administrador de recetas --}}
     <a  href="{{route('recetas.index')}}" class="btn btn-outline-danger mr-2 text-uppercsae font-weight-bold">
        <svg class="icono" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        Regresar al menu
    </a>
@endsection
{{-- Creando la pagina para crear recetas --}}
@section('content')
{{-- Titulo --}}
<h2 class="text-center mb-5">Crear Nueva Receta</h2>

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        {{-- Creando un formulario con el metodo POST --}}
        <form method="POST" action="{{route('recetas.store')}}" enctype="multipart/form-data" novalidate>
            {{-- Agregar el token del formulario --}}
            @csrf
            {{-- Titulo de la receta a crear --}}
            <div class="form-group">
                <label for="titulo">Titulo Receta</label>
                <input type="text" name="titulo" class="form-control @error ('titulo') is-invalid @enderror " id="titulo" placeholder="Titulo Receta" value={{old('titulo')}}>
                @error('titulo')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="from-group">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" class="form-control @error ('categoria') is-invalid @enderror">
                    <option value="">-- Seleccione --</option>
                    {{-- Obteniendo consulta de DB a traves de RecetaController --}}
                    @foreach($categorias as $categoria )
                        <option value="{{$categoria->id}}" {{old('categoria')== $categoria->id ? 'selected' : ''}}> 
                            {{-- Imprimiendo categorias --}}
                            {{$categoria->nombre}}
                        </option>
                    @endforeach
                </select>
                @error('categoria')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            {{-- Agregando el apartado de preparacion para crear una receta --}}
            <div class="form-group mt-3">
                <label for="preparacion">Preparación</label>
                <input id="preparacion" type="hidden" name="preparacion" value="{{ old('preparacion') }}" type="text">
                {{-- Agregando el editor --}}
                <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>
                @error('preparacion')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Agregando el apartado de ingredientes para crear una receta --}}
            <div class="form-group mt-3">
                <label for="ingredientes">Ingredientes</label>
                <input id="ingredientes" type="hidden" name="ingredientes" value="{{ old('ingredientes') }}" type="text">
                {{-- Agregando el editor --}}
                <trix-editor input="ingredientes" class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>
                @error('ingredientes')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="imagen">Agrega una imagen</label>
                <input id="imagen" type="file" class="form-control @error('imagen') is-invalid @enderror" name="imagen">
                @error('imagen')
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Boton de agregar receta --}}
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Agregar Receta">
            </div>
        </form>
    </div>

</div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js" integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
@endsection

