<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['curso_id', 'nombre', 'descripcion', 'duracion','calificacion'];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class)->orderBy('orden');
    }
}