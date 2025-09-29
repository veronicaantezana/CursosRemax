<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion', 
        'imagen', 
        'tiempoVigencia',
        'calificacion'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}