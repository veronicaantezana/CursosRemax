<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\DTOs\TestDto;
use App\Services\TestService;
use App\Services\CursoService;
use App\Http\Requests\StoreTestRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function __construct(
        private TestService $testService,
        private CursoService $cursoService
    ) {}

    
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


        if ($this->testService->existeTestEnCurso((int)$cursoId)) {
            return redirect()->route('admin.temas.index', $cursoId)
                ->with('error', 'Este curso ya tiene un test asignado');
        }

        return Inertia::render('Admin/Curso/Test/Create', [
            'curso' => $curso
        ]);
    }

    
    public function store(StoreTestRequest $request, string $cursoId): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        try {
            // Verificar si ya existe un test para este curso
            if ($this->testService->existeTestEnCurso((int)$cursoId)) {
                return redirect()->back()
                    ->with('error', 'Este curso ya tiene un test asignado')
                    ->withInput();
            }

            $testData = $request->validated();
            $testData['curso_id'] = $cursoId;

            $testDto = TestDto::fromRequest($testData);
            $test = $this->testService->createWithPreguntas($testDto, $request->preguntas);

            return redirect()->route('admin.temas.index', $cursoId)
                ->with('success', 'Test creado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el test: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function edit(string $cursoId, string $testId): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$cursoId);
        $test = $this->testService->findById((int)$testId);

        if (!$curso || !$test) {
            return redirect()->route('admin.temas.index', $cursoId)
                ->with('error', 'Curso o test no encontrado');
        }

        return Inertia::render('Admin/Curso/Test/Edit', [
            'curso' => $curso,
            'test' => $test
        ]);
    }


    public function show(string $cursoId, string $testId): Response|RedirectResponse
    {
        if (!Auth::check() || Auth::user()->role_id !== 2) {
            return redirect('/login');
        }

        $curso = $this->cursoService->findById((int)$cursoId);
        $test = $this->testService->findById((int)$testId);

        if (!$curso || !$test) {
            return redirect()->route('admin.temas.index', $cursoId)
                ->with('error', 'Curso o test no encontrado');
        }

        return Inertia::render('Admin/Curso/Test/Show', [
            'curso' => $curso,
            'test' => $test
        ]);
    }
}