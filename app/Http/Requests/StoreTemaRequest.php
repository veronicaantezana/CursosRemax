<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTemaRequest extends FormRequest
{
    public function authorize(): bool
    {
       return Auth::check() && Auth::user()->role_id === 2; 
    }

    public function rules(): array
    {
        return [
            'curso_id' => 'required|exists:cursos,id',
            'nombre' => 'required|string|max:255',
            'duracion' => 'required|integer|min:1',
            'archivo' => 'nullable|file|max:51200',
            'url' => 'nullable|url'
        ];
    }

    public function messages(): array
    {
        return [
            'curso_id.required' => 'El curso es obligatorio',
            'nombre.required' => 'El nombre del tema es obligatorio',
            'duracion.required' => 'La duración es obligatoria',
            'duracion.min' => 'La duración debe ser de al menos 1 minuto',
            'archivo.max' => 'El archivo no debe superar los 50MB',
            'url.url' => 'La URL debe tener un formato válido'
        ];
    }
}