<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receta extends Model
{
    //Campos que se agregaran a db
    protected $fillable = [
        'titulo',
        'preparacion',
        'ingredientes',
        'imagen',
        'categoria_id'
    ];

    //Obteniendo las categorias de la receta via llave foranea o FK
    public function categoria(){
        return $this->belongsTo(CategoriaReceta::class);
    }

    // Obtiene la informacion del usuario FK
    public function autor() {
        return $this->belongsTo(User::class, 'user_id'); //Es el FK de esta tabla
    }

    // Likes que han recibido una receta
    public function likes()
    {
        return $this->belongsToMany(User::class,'likes_receta');
    }

}
