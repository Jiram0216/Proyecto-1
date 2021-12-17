<?php

namespace App\Http\Controllers;

use App\Models\CategoriaReceta;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{

    public function __construct()
    {
        // Protegiendo los metodos con middleware excepto el metodo show
        $this->middleware('auth', ['except' => ['show', 'search']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Obtener Id del Usuario Logueado
        $usuario = Auth::user();
        
        //Obtener las recetas metodo Auth.
        //Auth::user()->recetas->dd();

        // Funcion auth
        // $usuario = auth()->user();
        // $recetas = auth()->user()->recetas;

        // Metodo par obtener las recetas con paginacion
        $recetas = Receta::where('user_id', $usuario->id)->paginate(5);

        return view('recetas.index')->with('recetas', $recetas)->with('usuario', $usuario);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener categoria_recetas de la base de datos (sin modelo).
        // DB::table('categoria_recetas')->get()->pluck('nombre', 'id')->dd();
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        // Obtener categoria_recetas de la base de datos (con modelo).
        $categorias = CategoriaReceta::all(['id', 'nombre']);


        // Retornando el vio de recetas.create y pasando los datos de la categorias con with
        return view('/recetas/create')->with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request['imagen']->store('upload-recetas', 'public'));

        $data = request()->validate([
            // Validacion de los elamentos para el formulario
            'titulo'=>'required|min:6',
            // Validando categoria
            'categoria'=>'required',
            'preparacion'=>'required',
            'ingredientes'=>'required',
            'imagen'=>'required|image'
        ]);
        
        //Obtenemos la ruta de la ruta_imagen .
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
        
        // Resize de la imagen
        $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1200,550);
        $img ->save();

        //Agregmos todos los datos a la DB (Sin Modelo)
        // DB::table('recetas')->insert([
        //     'titulo' => $data['titulo'],
        //     'preparacion' => $data['preparacion'],
        //     'ingredientes' => $data['ingredientes'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria']
        // ]);
        
        //Agregmos todos los datos a la DB (Con Modelo)
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' =>  $ruta_imagen,
            'categoria_id' => $data['categoria']
        ]);
        
        //Redirreccionar la pagina una ves creado una nueva receta
        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        // Obtener si el usuario actual le gusta la receta y esta autenticado
        $like = (auth()->user()) ? auth()->user()->meGusta->contains($receta->id) : false;

        // Pasa la cantidad de likes a la vista
        $likes = $receta->likes->count();

        // Cargando la pagina y enviando la consulta de las bases de datos
        return view('recetas.show', compact('receta', 'like', 'likes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        // Ejecutando el policy
        $this->authorize('view', $receta);

        // Obtener categoria_recetas de la base de datos (con modelo).
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        // Redirigiendo a vista de edit.blade.php
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        $this->authorize('update', $receta);

        $data = request()->validate([
            // Validacion de los elamentos para el formulario
            'titulo'=>'required|min:6',
            // Validando categoria
            'categoria'=>'required',
            'preparacion'=>'required',
            'ingredientes'=>'required',
        ]);

        // Asignar los valores
        $receta->titulo = $data['titulo'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];
        $receta->categoria_id = $data['categoria'];
        

        // Si el usuario agrega una nueva imagen
        if(request('imagen')){
            //Obtenemos la ruta de la ruta_imagen .
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            
            // Resize de la imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(1200,550);
            $img ->save();

            // Aseginar al objeto
            $receta->imagen =$ruta_imagen;
        }
        // Guardando la receta
        $receta->save();
        // redireccionar
        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {

        // Ejecutar Policy
        $this->authorize('delete', $receta);

        //Eliminar receta
        $receta->delete();

        return redirect()->action([RecetaController::class, 'index']);
    }

    public function search (Request $request)
    {
        // $busqueda = $request['buscar'];
        $busqueda = $request->get('buscar');

        $recetas = Receta::where('titulo','like','%' . $busqueda . '%')->paginate(3);
        $recetas->appends(['buscar' => $busqueda]);
        return view('busquedas.show',compact('recetas','busqueda'));
    }
}
