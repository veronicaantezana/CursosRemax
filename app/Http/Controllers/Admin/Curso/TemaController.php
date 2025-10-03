<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\DTOs\TemaDto;
use App\Services\TemaService;
use App\Services\CursoService;
use App\Http\Requests\StoreTemaRequest;
use App\Http\Requests\UpdateTemaRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class TemaController extends Controller
{
    public function __construct(
        private TemaService $temaService,
        private CursoService $cursoService
    ) {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $cursoId): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$cursoId);

        if (!$curso) {
            return redirect()->route('admin.cursos.index')
                ->with('error', 'Curso no encontrado');
        }

        return Inertia::render('Admin/Curso/CreateTema', [
            'curso' => $curso
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $cursoId): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$cursoId);

        if (!$curso) {
            return redirect()->route('admin.cursos.index')
                ->with('error', 'Curso no encontrado');
        }

        $temas = $this->temaService->getByCurso((int)$cursoId);

        return Inertia::render('Admin/Curso/IndexTema', [
            'curso' => $curso,
            'temas' => $temas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $cursoId, string $temaId): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$cursoId);
        $tema = $this->temaService->findById((int)$temaId);

        if (!$curso || !$tema) {
            return redirect()->route('admin.cursos.temas.index', $cursoId)
                ->with('error', 'Curso o tema no encontrado');
        }

        return Inertia::render('Admin/Curso/EditTema', [
            'curso' => $curso,
            'tema' => $tema
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTemaRequest $request): RedirectResponse
    {
        try {
            $temaData = [
                'curso_id' => $request->curso_id,
                'nombre' => $request->nombre,
                'duracion' => $request->duracion,
                'url' => $request->url
            ];

            $dto = TemaDto::fromRequest($temaData);
            $tema = $this->temaService->createWithFiles($dto, $request->file('archivo'));

            $message = $this->generateSuccessMessage($request);

            return redirect()->route('admin.cursos.temas.index', $request->curso_id)
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el tema: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemaRequest $request, string $curso, string $tema): RedirectResponse
    {
        try {
            $temaData = $request->only(['nombre', 'duracion', 'url']);
            
            // Incluir curso_id del tema existente
            $temaExistente = $this->temaService->findById((int)$tema);
            if ($temaExistente) {
                $temaData['curso_id'] = $temaExistente->curso_id;
            }

            $dto = TemaDto::fromRequest($temaData);
            
            $updated = $this->temaService->updateWithFiles(
                (int)$tema, 
                $dto, 
                $request->file('archivo'),
                $request->boolean('remove_archivo'),
                $request->boolean('remove_url')
            );

            if (!$updated) {
                return redirect()->back()
                    ->with('error', 'Error al actualizar el tema.')
                    ->withInput();
            }

            return redirect()->route('admin.temas.index', $curso)
                ->with('success', 'Tema actualizado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el tema: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $curso, string $tema): RedirectResponse
    {
        try {
            $deleted = $this->temaService->deleteWithFiles((int)$tema);

            if (!$deleted) {
                return redirect()->back()
                    ->with('error', 'Error al eliminar el tema o tema no encontrado');
            }

            return redirect()->back()
                ->with('success', 'Tema eliminado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el tema: ' . $e->getMessage());
        }
    }

    /**
     * Generate success message based on request data
     */
    private function generateSuccessMessage(Request $request): string
    {
        $message = 'Tema creado exitosamente';

        if ($request->hasFile('archivo') && $request->url) {
            $message .= ' con archivo y URL';
        } elseif ($request->hasFile('archivo')) {
            $message .= ' con archivo';
        } elseif ($request->url) {
            $message .= ' con URL';
        }

        return $message;
    }
}