<?php

namespace App\Services;

use App\DTOs\TemaDto;
use App\Models\Tema;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TemaService
{
    public function __construct(
        private Tema $temaModel
    ) {}

    /**
     * Obtener todos los temas de un curso
     */
    public function getAllByCurso(int $cursoId): Collection
    {
          return $this->temaModel
            ->where('curso_id', $cursoId)
            ->latest()
            ->get();
    }

    /**
     * Obtener tema por ID
     */
    public function findById(int $id): ?Tema
    {
        Log::info('Buscando tema por ID', ['id' => $id]);
        $tema = $this->temaModel->find($id);
        Log::info('Resultado búsqueda tema', ['encontrado' => !is_null($tema)]);
        return $tema;
    }

    public function create(TemaDto $dto): Tema
    {
         Log::info('Service create tema - Iniciando', $dto->toArray());
        return $this->temaModel->create($dto->toArray());
    }

    public function update(int $id, TemaDto $dto): bool
    {
        Log::info('Service update tema - Iniciando', [
            'id' => $id,
            'dto' => $dto->toArray()
        ]);

        $tema = $this->findById($id);

        if (!$tema) {
            Log::warning('Service update tema - Tema no encontrado', ['id' => $id]);
            return false;
        }

        Log::info('Service update tema - Datos a actualizar', $dto->toArray());
        Log::info('Service update tema - Estado antes', [
            'nombre_actual' => $tema->nombre,
            'duracion_actual' => $tema->duracion
        ]);

        return $tema->update($dto->toArray());
    }

    public function delete(int $id): bool
    {
        $tema = $this->findById($id);

        if (!$tema) {
            return false;
        }

        return $tema->delete();
    }


    public function nombreExistsInCurso(string $nombre, int $cursoId, ?int $excludeId = null): bool
    {
        $query = $this->temaModel
            ->where('nombre', $nombre)
            ->where('curso_id', $cursoId);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Obtener temas por cursos
     */
    public function getByCurso(int $cursoId)
    {
        return $this->temaModel
            ->where('curso_id', $cursoId)
            ->orderBy('id')
            ->get();
    }
    public function createWithFiles(TemaDto $dto, $archivo = null): Tema
    {
        $temaData = $dto->toArray();

        if ($archivo) {
            $path = $archivo->store('temas', 'public');
            $temaData['archivo_path'] = $path;
            $temaData['tipo_archivo'] = (new Tema())->detectarTipoArchivo($archivo);
        }

        if ($dto->url && !$archivo) {
            $temaData['tipo_archivo'] = 'video';
        }

        return $this->temaModel->create($temaData);
    }

     public function updateWithFiles(int $id, TemaDto $dto, $archivo = null, bool $removeArchivo = false, bool $removeUrl = false): bool
    {
        $tema = $this->findById($id);

        if (!$tema) {
            return false;
        }

        $temaData = $dto->toArray();

        // Procesar nuevo archivo
        if ($archivo) {
            // Eliminar archivo anterior si existe
            if ($tema->archivo_path && Storage::disk('public')->exists($tema->archivo_path)) {
                Storage::disk('public')->delete($tema->archivo_path);
            }

            $path = $archivo->store('temas', 'public');
            $temaData['archivo_path'] = $path;
            $temaData['tipo_archivo'] = (new Tema())->detectarTipoArchivo($archivo);
        }

        // Manejar eliminación de archivo
        if ($removeArchivo) {
            if ($tema->archivo_path && Storage::disk('public')->exists($tema->archivo_path)) {
                Storage::disk('public')->delete($tema->archivo_path);
            }
            $temaData['archivo_path'] = null;
            $temaData['tipo_archivo'] = $dto->url ? 'video' : null;
        }

        // Manejar eliminación de URL
        if ($removeUrl) {
            $temaData['url'] = null;
            if (!$archivo && !isset($temaData['archivo_path'])) {
                $temaData['tipo_archivo'] = null;
            }
        }

        return $tema->update($temaData);
    }
    public function deleteWithFiles(int $id): bool
    {
        $tema = $this->findById($id);

        if (!$tema) {
            return false;
        }

        // Eliminar archivo si existe
        if ($tema->archivo_path && Storage::disk('public')->exists($tema->archivo_path)) {
            Storage::disk('public')->delete($tema->archivo_path);
        }

        return $tema->delete();
    }


}
