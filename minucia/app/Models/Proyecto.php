<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ['nombre'];

    // Relación: un proyecto tiene muchos bloques
    public function bloques()
    {
        return $this->hasMany(Bloque::class);
    }
}
