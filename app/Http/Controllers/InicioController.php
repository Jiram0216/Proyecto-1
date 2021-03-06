<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;

class InicioController extends Controller
{
    public function index(){

        // Mostrar recetas por cantidad de votos
        // $votadas = Receta::has('likes', '>', 1)->get();
        $votadas = Receta::withCount('likes')->orderBy('likes_count','DESC')->take(3)->get();

        // Obtener las recetas mas nuevas
        $nuevas = Receta::latest()->limit(5)->get();

        // Obtener todas las categorias
        $categorias = CategoriaReceta::all();
        
        // Arreglo de recetas para agrupar las recetas por categoria
        $recetas = [];

        // Agrupar las recetas por categoria
        foreach($categorias as $categoria ){
            $recetas[Str::slug($categoria->nombre)][] = Receta::where('categoria_id', $categoria->id )->take(3)->get();
        }
        
        return view('inicio.index', compact('nuevas', 'recetas', 'votadas'));
    }
}
