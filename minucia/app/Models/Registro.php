<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registro extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'pieza_id',
        'peso_real',
    ];

    // Relación: el registro pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: el registro pertenece a una pieza
    public function pieza()
    {
        return $this->belongsTo(Pieza::class);
    }
}

