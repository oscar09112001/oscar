<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    // Campos que se pueden asignar masivamente (desde formularios o controladores)
    protected $fillable = ['nombre', 'proyecto_id'];

    // Relación: un bloque pertenece a un proyecto
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    // Relación: un bloque tiene muchas piezas
    public function piezas()
    {
        return $this->hasMany(Pieza::class);
    }
}
