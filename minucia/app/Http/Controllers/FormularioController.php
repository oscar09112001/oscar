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
    // Este método muestra la vista principal del formulario
    // Carga todos los proyectos con sus bloques y piezas asociadas
    public function index()
    {
        $proyectos = Proyecto::with('bloques.piezas')->get(); // Trae toda la estructura jerárquica
        
        return Inertia::render('Formulario', [
            'proyectos' => $proyectos, // Enviamos los proyectos al frontend (Vue)
            'flash' => [
                'success' => session('success'), // Captura mensaje de éxito si existe
            ]
        ]);
    }

    // Este método guarda un nuevo registro enviado desde el formulario
    public function store(Request $request)
    {
        // Validamos que la pieza exista y que el peso sea un número
        $request->validate([
            'pieza_id' => 'nullable|integer|exists:piezas,id',
            'peso_real' => 'required|numeric',
        ]);

        // Creamos el registro con el ID del usuario logueado
        Registro::create([
            'user_id' => Auth::id(), // Se asigna automáticamente el usuario actual
            'pieza_id' => $request->pieza_id,
            'peso_real' => $request->peso_real,
        ]);

        // Redirige al listado de reportes con un mensaje flash de éxito
        return redirect()->route('formulario.reportes')->with('success', 'Registro guardado exitosamente');
    }

    // Este método muestra todos los registros guardados en la base de datos
    public function reportes()
    {
        // Cargamos los registros con relaciones: usuario, pieza, bloque y proyecto
        $registros = Registro::with([
            'user',
            'pieza.bloque.proyecto'
        ])
        ->latest() // Orden descendente (más recientes primero)
        ->get();

        // Retornamos la vista de reportes con todos los registros
        return Inertia::render('Reportes', [
            'registros' => $registros,
        ]);
    }
}
