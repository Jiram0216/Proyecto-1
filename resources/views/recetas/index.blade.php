{{-- Extendiendo desde layout app para usar el diseño --}}
@extends('layouts.app')
{{-- creando botones para redirigir --}}
@section('botones')
     {{-- integrando botones --}}
     @include('ui.navegacion')
@endsection
{{-- Obteniendo el diseño de layouts.app y creando diseño nuevo para la pagina de recetas a traves de codigo boostrap --}}
{{-- Creando la pagina para administrar recetas --}}
@section('content')
{{-- Titulo --}}
<h2 class="text-center mb-5">Administra tus Recetas</h2>
<div class="col-md-10 mx-auto bg-white p-3">
     <table class="table">
          <thead class="bg-primary text-light">
               <tr>
                    <th scole="col">Titulos</th>
                    <th scole="col">Categorias</th>
                    <th scole="col">Acciones</th>
               </tr>
          </thead> 
          
          <body>
               @foreach($recetas as $receta )
                    <tr>
                         <td>{{$receta->titulo}}</td>
                         <td>{{$receta->categoria->nombre}}</td>
                         <td>
                              <eliminar-receta receta-id={{$receta->id}}></eliminar-receta>
                              <a href="{{route( 'recetas.edit', ['receta' =>$receta->id])}}" class="btn btn-dark d-block w-100 mb-2">editar</a>
                              <a href="{{route( 'recetas.show',['receta' => $receta->id])}}" class="btn btn-success d-block w-100 mb-2">Ver</a>
                         </td>
                    </tr>
               @endforeach
          </body>
     </table>  
     <div class="col-12 mt-4 justify-content-center d-flex">
          {{ $recetas->links() }}
     </div>
     {{-- Mostrando las recetas que le gustan --}}
     <h2 class="text-center my-5">Recetas que te gustan</h2>
     <div class="col-md10 mx-auto bg-white p-3">
          {{--  --}}
          @if(count($usuario->meGusta) > 0 )
               <ul class="list-group">
                    @foreach($usuario->meGusta as $receta)
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                              {{-- Mostrar el titulo de la receta --}}
                              <p>{{$receta->titulo}}</p>
                              {{-- Enlace para ver la receta --}}
                              <a href=" {{route('recetas.show', ['receta' => $receta->id])}}">Ver</a>
                         </li>
                    @endforeach
               </ul>
          @else
          <p class="text-center">Aún no tienes recetas Guadadas <small>Dale me gusta a las recetas y aparecerán aquí.</small></p>
          @endif
     </div>
</div>
@endsection

