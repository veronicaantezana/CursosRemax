<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role_id === 2; 
    }

    public function rules(): array
    {
        return [
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255|unique:cursos,nombre',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|string|max:500',
            'tiempoVigencia' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_id.required' => 'La categoría es obligatoria',
            'categoria_id.exists' => 'La categoría seleccionada no existe',
            'nombre.required' => 'El nombre del curso es obligatorio',
            'nombre.unique' => 'Ya existe un curso con este nombre',
            'tiempoVigencia.required' => 'El tiempo de vigencia es obligatorio',
            'tiempoVigencia.min' => 'El tiempo de vigencia debe ser al menos 1'
        ];
    }
}