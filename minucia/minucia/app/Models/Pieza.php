<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
     protected $fillable = ['nombre', 'peso_teorico', 'estado', 'bloque_id'];

    public function bloque()
    {
        return $this->belongsTo(Bloque::class);
    }
}
