<?php

namespace App\Services;

use App\DTOs\CursoDto;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CursoService
{
    public function __construct(
        private Curso $cursoModel
    ) {}


    public function getAll(): Collection
    {
        return $this->cursoModel->with('categoria')->latest()->get();
    }


    public function getPaginated(int $perPage = 10)
    {
        return $this->cursoModel->with('categoria')->latest()->paginate($perPage);
    }


    public function findById(int $id): ?Curso
    {
        return $this->cursoModel->with('categoria')->find($id);
    }


    public function create(CursoDto $dto): Curso
    {
        return $this->cursoModel->create($dto->toArray());
    }

    public function update(int $id, CursoDto $dto): bool
    {
        $curso = $this->findById($id);

        if (!$curso) {
            Log::warning('CursoService - Curso no encontrado', ['id' => $id]);
            return false;
        }

        return $curso->update($dto->toArray());
    }


    public function delete(int $id): bool
    {
        $curso = $this->findById($id);

        if (!$curso) {
            return false;
        }

        return $curso->delete();
    }

    public function nombreExists(string $nombre, ?int $excludeId = null): bool
    {
        $query = $this->cursoModel->where('nombre', $nombre);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

   
    public function getByCategoria(int $categoriaId): Collection
    {
        return $this->cursoModel->with('categoria')
            ->where('categoria_id', $categoriaId)
            ->latest()
            ->get();
    }
}
