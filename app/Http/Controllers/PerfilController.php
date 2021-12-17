<?php

namespace App\Http\Controllers;

use App\Models\perfil;
use App\Models\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Symfony\Contracts\Service\Attribute\Required;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(perfil $perfil)
    {
        // Obtener las recetas con paginacion
        $recetas = Receta::where('user_id', $perfil->user_id)->paginate(5);

        return view('perfiles.show', compact('perfil', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(perfil $perfil)
    {
        // Ejecutar el policy
        $this->authorize('view', $perfil);

        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, perfil $perfil)
    {
        // Ejecutar el policy
        $this->authorize('update', $perfil);

        // Validar
        $data = request()->validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required'
        ]);

        // Si el usuario sube una imagen
        if($request['imagen']){
            //Obtenemos la ruta de la ruta_imagen .
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');
            
            // Resize de la imagen
            $img = Image::make( public_path("storage/{$ruta_imagen}"))->fit(600,600);
            $img ->save();

            // crear un arreglo de imagen
            $array_imagen = ['imagen' => $ruta_imagen];
        } 


        // Asignar nombre y url
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();

        // Eliminar url y name de $data
        unset($data['url']);
        unset($data['nombre']);

        // Guradar informacion
        // Asignar biografia y imagen
        auth()->user()->perfil()->update( array_merge($data, $array_imagen ?? []));

        // redireccionar
        return redirect()->action([RecetaController::class, 'index']);
    }
}
