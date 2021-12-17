<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whict
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/inicio', [App\Http\Controllers\InicioController::class, 'index'])->name('inicio.index');


//Creando la ruta hacia mi RecetaController
Route::get('/recetas', [App\Http\Controllers\RecetaController::class, 'index'])->name('recetas.index');
Route::get('/recetas/create', [App\Http\Controllers\RecetaController::class, 'create'])->name('recetas.create');
Route::post('/recetas', [App\Http\Controllers\RecetaController::class, 'store'])->name('recetas.store');
Route::get('/recetas/{receta}', [App\Http\Controllers\RecetaController::class, 'show'])->name('recetas.show');
Route::get('/recetas/{receta}/edit', [App\Http\Controllers\RecetaController::class, 'edit'])->name('recetas.edit');
Route::put('/recetas/{receta}', [App\Http\Controllers\RecetaController::class, 'update'])->name('recetas.update');
Route::delete('/recetas/{receta}', [App\Http\Controllers\RecetaController::class, 'destroy'])->name('recetas.destroy');

// Route::resource('recetas', 'RecetaController');
Route::get('/categoria/{categoriaReceta}',[App\Http\Controllers\CategoriasController::class,'show'])->name('categorias.show');

// Buscador de recetas
Route::get('/buscar', [App\Http\Controllers\RecetaController::class, 'search'])->name('buscar.show');

// Administrando los perfiles de usuarios
Route::get('/perfiles/{perfil}', [App\Http\Controllers\PerfilController::class, 'show'])->name('perfiles.show');
Route::get('/perfiles/{perfil}/edit', [App\Http\Controllers\PerfilController::class, 'edit'])->name('perfiles.edit');
Route::put('/perfiles/{perfil}', [App\Http\Controllers\PerfilController::class, 'update'])->name('perfiles.update');

// Almacena los likes de las recetas
Route::post('/recetas/{receta}', [App\Http\Controllers\LikesController::class, 'update'])->name('likes.update');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
