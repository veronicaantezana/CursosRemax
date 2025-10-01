<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role_id === 2; 
    }

    public function rules(): array
    {
        $cursoId = $this->route('id');

        return [
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:cursos,nombre,' . $cursoId,
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string|max:500',
            'tiempoVigencia' => 'required|integer|min:1',
            'calificacion' => 'nullable|numeric|min:0|max:5'
        ];
    }
}