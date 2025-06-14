<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\Bloque;
use App\Models\Pieza;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un usuario
        $user = User::create([
            'name' => 'Usuario Demo',
            'email' => 'usuario@demo.com',
            'password' => Hash::make('password'),
        ]);

        // Crear un proyecto
        $proyecto = Proyecto::create([
            'nombre' => 'Proyecto A',
        ]);

        // Crear un bloque asociado
        $bloque = Bloque::create([
            'nombre' => 'Bloque A1',
            'proyecto_id' => $proyecto->id,
        ]);

        // Crear piezas asociadas al bloque
        Pieza::create([
            'nombre' => 'Pieza 1',
            'bloque_id' => $bloque->id,
        ]);

        Pieza::create([
            'nombre' => 'Pieza 2',
            'bloque_id' => $bloque->id,
        ]);
    }
}
