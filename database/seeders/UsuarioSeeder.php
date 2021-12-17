<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name'=> 'Jiram Ezequiel', 
            'email'=> 'jiram@hotmail.com', 
            'password'=> Hash::make('Jiram@0216'), 
            'url'=> 'https://primerproyecto-lanasa.netlify.app/',
        ]);
        $user2 = User::create([
            'name'=> 'Andrea', 
            'email'=> 'andrea@hotmail.com', 
            'password'=> Hash::make('Jiram@0216'), 
            'url'=> 'https://primerproyecto-lanasa.netlify.app/',
        ]);
    }
}
