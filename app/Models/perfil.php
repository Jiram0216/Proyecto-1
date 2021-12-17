<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perfil extends Model
{
    // relacion 1 a 1 de perfil de usuario
    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
