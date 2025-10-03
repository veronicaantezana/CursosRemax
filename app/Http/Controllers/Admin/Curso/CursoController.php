<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\DTOs\CursoDto;
use App\Http\Requests\StoreCursoRequest;
use App\Http\Requests\UpdateCursoRequest;
use App\Services\CursoService;
use App\Services\CategoriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function __construct(
        private CursoService $cursoService,
        private CategoriaService $categoriaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            abort(403, 'No autorizado');
        }

        $cursos = $this->cursoService->getAll();

        return Inertia::render('Admin/Curso/Index', [
            'cursos' => $cursos
        ]);
    }

    public function create(): Response
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            abort(403, 'No autorizado');
        }

        $categorias = $this->categoriaService->getAll();

        return Inertia::render('Admin/Curso/Create', [
            'categorias' => $categorias
        ]);
    }


    public function store(StoreCursoRequest $request): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            $dto = CursoDto::fromRequest($request->validated());
            $curso = $this->cursoService->create($dto);

            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el curso: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit(string $id): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$id);

        if (!$curso) {
            return redirect()->route('admin.cursos.index')
                ->with('error', 'Curso no encontrado');
        }

        $categorias = $this->categoriaService->getAll();

        return Inertia::render('Admin/Curso/Edit', [
            'curso' => $curso,
            'categorias' => $categorias
        ]);
    }


    public function update(UpdateCursoRequest $request, string $id): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            if (!is_numeric($id)) {
                return redirect()->back()
                    ->with('error', 'ID de curso inválido.')
                    ->withInput();
            }

            $dto = CursoDto::fromRequest($request->validated());
            $updated = $this->cursoService->update((int)$id, $dto);

            if (!$updated) {
                return redirect()->back()
                    ->with('error', 'Error al actualizar el curso.')
                    ->withInput();
            }

            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el curso: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy(string $id): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            $deleted = $this->cursoService->delete((int)$id);

            if (!$deleted) {
                return redirect()->back()
                    ->with('error', 'Error al eliminar el curso o curso no encontrado');
            }

            return redirect()->route('admin.cursos.index')
                ->with('success', 'Curso eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }
}
