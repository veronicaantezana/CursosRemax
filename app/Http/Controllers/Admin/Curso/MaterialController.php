<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\DTOs\MaterialDto;
use App\Services\MaterialService;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function __construct(
        private MaterialService $materialService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            $request->validate([
                'tema_id' => 'required|exists:temas,id',
                'archivo' => 'nullable|file|max:10240', // 10MB máximo
                'url' => 'nullable|url'
            ]);

            // Verificar que tenga archivo O URL, no ambos
            if (!$request->hasFile('archivo') && !$request->url) {
                return redirect()->back()
                    ->with('error', 'Debe subir un archivo o proporcionar una URL')
                    ->withInput();
            }

            $dto = MaterialDto::fromRequest($request->all());
            $material = $this->materialService->create($dto);

            return redirect()->back()
                ->with('success', 'Material agregado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al agregar el material: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            $deleted = $this->materialService->delete((int)$id);

            if (!$deleted) {
                return redirect()->back()
                    ->with('error', 'Error al eliminar el material o material no encontrado');
            }

            return redirect()->back()
                ->with('success', 'Material eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el material: ' . $e->getMessage());
        }
    }
}