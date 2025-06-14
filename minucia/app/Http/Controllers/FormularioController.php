<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Pieza;
use App\Models\Registro;
use App\Models\Proyecto;

class FormularioController extends Controller
{
    public function index()
    {
        
        $proyectos = Proyecto::with('bloques.piezas')->get();

        return Inertia::render('Formulario', [
            'proyectos' => $proyectos,
            'flash' => [
                'success' => session('success'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pieza_id' => 'nullable|integer|exists:piezas,id',
            'peso_real' => 'required|numeric',
        ]);

        Registro::create([
            'user_id' =>  Auth::id(),
            'pieza_id' => $request->pieza_id,
            'peso_real' => $request->peso_real,
        ]);

         return redirect()->route('formulario.reportes')->with('success', 'Registro guardado exitosamente');
    }
    public function reportes()
{
    $registros = \App\Models\Registro::with([
        'user',
        'pieza.bloque.proyecto'
    ])
    ->latest()
    ->get();

    return Inertia::render('Reportes', [
        'registros' => $registros,
    ]);
}

}
