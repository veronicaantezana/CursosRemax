<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $fillable = ['test_id', 'enunciado', 'tipo', 'orden'];

    //  necesitan opciones
    const TIPOS_CON_OPCIONES = ['seleccion_unica', 'seleccion_multiple', 'verdadero_falso'];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }

    public function necesitaOpciones()
    {
        return in_array($this->tipo, self::TIPOS_CON_OPCIONES);
    }
}