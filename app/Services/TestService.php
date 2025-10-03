<?php

namespace App\Services;

use App\DTOs\TestDto;
use App\Models\Test;
use App\Models\Pregunta;
use App\Models\Opcion;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestService
{
    public function __construct(
        private Test $testModel,
        private Pregunta $preguntaModel,
        private Opcion $opcionModel
    ) {}

    public function findByCursoId(int $cursoId): ?Test
    {
        return $this->testModel->where('curso_id', $cursoId)->first();
    }

    public function findById(int $id): ?Test
    {
        return $this->testModel->with(['preguntas.opciones'])->find($id);
    }

    public function createWithPreguntas(TestDto $testDto, array $preguntasData): Test
    {
        return DB::transaction(function () use ($testDto, $preguntasData) {
            $test = $this->testModel->create($testDto->toArray());
            foreach ($preguntasData as $index => $preguntaData) {
                $pregunta = $this->preguntaModel->create([
                    'test_id' => $test->id,
                    'enunciado' => $preguntaData['enunciado'],
                    'tipo' => $preguntaData['tipo'],
                    'orden' => $index
                ]);


                if (in_array($preguntaData['tipo'], ['seleccion_unica', 'seleccion_multiple', 'verdadero_falso'])) {
                    foreach ($preguntaData['opciones'] as $opcionData) {
                        $this->opcionModel->create([
                            'pregunta_id' => $pregunta->id,
                            'texto' => $opcionData['texto'],
                            'es_correcta' => $opcionData['es_correcta']
                        ]);
                    }
                }
            }

            return $test->load(['preguntas.opciones']);
        });
    }

    public function update(TestDto $testDto, int $id): bool
    {
        $test = $this->findById($id);
        
        if (!$test) {
            return false;
        }

        return $test->update($testDto->toArray());
    }

    public function delete(int $id): bool
    {
        $test = $this->findById($id);
        
        if (!$test) {
            return false;
        }

        return $test->delete();
    }

    public function existeTestEnCurso(int $cursoId): bool
    {
        return $this->testModel->where('curso_id', $cursoId)->exists();
    }
}