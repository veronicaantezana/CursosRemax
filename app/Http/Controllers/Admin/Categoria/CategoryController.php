<?php

namespace App\Http\Controllers\Admin\Categoria;

use App\Http\Controllers\Controller;
use App\DTOs\CategoriaDto;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Inertia\Inertia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\CategoriaService;

class CategoryController extends Controller
{
    protected $categoriaService;

    public function __construct(CategoriaService $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if (!externalAuth() || !isAdmin()) {
        return redirect('/login');
    }
        $categorias = $this->categoriaService->getAll();

        return Inertia::render('Admin/Categoria/Index', [
            'categorias' => $categorias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!externalAuth() || !isAdmin()) {
            return redirect('/login');
        }

        return Inertia::render('Admin/Categoria/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        if (!externalAuth() || !isAdmin()) {
            return redirect('/login');
        }

        try {
            $validated = $request->validated();
            // Crear DTO desde el request validado
            $dto = CategoriaDto::fromRequest(array_merge($validated, [
                'created_by' => currentUser()['id'] // ← ID del usuario logueado
            ]));
            // Usar el servicio para crear la categoría
            $categoria = $this->categoriaService->create($dto);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Categoría creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', ' Error al crear la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function edit(string $id)
    {
        if (!externalAuth() || !isAdmin()) {
            return redirect('/login');
        }
        $categoria = $this->categoriaService->findById($id);

        if (!$categoria) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Categoría no encontrada');
        }

        return Inertia::render('Admin/Categoria/Edit', [
            'categoria' => $categoria
        ]);
    }
    public function update(UpdateCategoriaRequest $request, string $id): RedirectResponse
    {
        if (!externalAuth() || !isAdmin()) {
            return redirect('/login');
        }

        try {
            // Crear DTO desde el request validado
            $dto = CategoriaDto::fromRequest($request->validated());

            // Usar el servicio para actualizar la categoría
            $updated = $this->categoriaService->update($id, $dto);

            if (!$updated) {
                return redirect()->back()
                    ->with('error', 'Error al actualizar la categoría.')
                    ->withInput();
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Categoría actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar la categoría: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id): RedirectResponse
    {
        if (!externalAuth() || !isAdmin()) {
            return redirect('/login');
        }

        try {
            // Usar el servicio para eliminar la categoría
            $deleted = $this->categoriaService->delete($id);

            if (!$deleted) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Categoría no encontrada');
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Categoría eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Error al eliminar la categoría: ' . $e->getMessage());
        }
    }
}
