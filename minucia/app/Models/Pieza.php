<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    // Campos que se pueden asignar de forma masiva
    protected $fillable = ['nombre', 'peso_teorico', 'estado', 'bloque_id'];

    // Relación: cada pieza pertenece a un bloque
    public function bloque()
    {
        return $this->belongsTo(Bloque::class);
    }
}

