<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role_id === 2;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer|min:5|max:180',
            'calificacion' => 'nullable|numeric|min:0|max:100|decimal:0,2',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.enunciado' => 'required|string|max:1000',
            'preguntas.*.tipo' => 'required|in:seleccion_unica,seleccion_multiple,verdadero_falso,respuesta_corta,respuesta_larga',
            'preguntas.*.opciones' => 'required_if:preguntas.*.tipo,seleccion_unica,seleccion_multiple,verdadero_falso|array',
            'preguntas.*.opciones.*.texto' => 'required_if:preguntas.*.tipo,seleccion_unica,seleccion_multiple,verdadero_falso|string|max:500',
            'preguntas.*.opciones.*.es_correcta' => 'required_if:preguntas.*.tipo,seleccion_unica,seleccion_multiple,verdadero_falso|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del test es obligatorio',
            'duracion.required' => 'La duración es obligatoria',
            'duracion.min' => 'La duración mínima no puede ser negativa',
            'preguntas.required' => 'Debe agregar al menos una pregunta',
            'preguntas.*.enunciado.required' => 'El enunciado de la pregunta es obligatorio',
            'preguntas.*.tipo.required' => 'El tipo de pregunta es obligatorio',
            'preguntas.*.opciones.required_if' => 'Las opciones son requeridas para este tipo de pregunta',
            'preguntas.*.opciones.*.texto.required_if' => 'El texto de la opción es obligatorio'
        ];
    }
}