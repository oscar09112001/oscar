<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pieza_id',
        'peso_real',
    ];
        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pieza()
    {
        return $this->belongsTo(Pieza::class);
    }

}
