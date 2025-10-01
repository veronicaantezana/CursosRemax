<?php

namespace App\Services;

use App\DTOs\CategoriaDto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class CategoriaService
{
    public function __construct(
        private Categoria $categoriaModel
    ) {}

    /**
     * Obtener todas las categorías
     */
    public function getAll(): Collection
    {
        return $this->categoriaModel->latest()->get();
    }

    /**
     * Obtener categoría por ID
     */
    /**
     * Obtener categoría por ID
     */
    public function findById(int $id): ?Categoria
    {
        Log::info('Buscando categoría por ID', ['id' => $id, 'tipo' => gettype($id)]);
        $categoria = $this->categoriaModel->find($id);
        Log::info('Resultado búsqueda', ['encontrado' => !is_null($categoria)]);
        return $categoria;
    }

    /**
     * Crear
     */
    public function create(CategoriaDto $dto): Categoria
    {
        return $this->categoriaModel->create($dto->toArray());
    }

    /**
     * Actualizar categoría
     */
    public function update(int $id, CategoriaDto $dto): bool
    {
        Log::info('Service update - Iniciando', [
            'id' => $id,
            'type' => gettype($id),
            'dto' => $dto->toArray()
        ]);

        $categoria = $this->findById($id);

        if (!$categoria) {
            Log::warning('Service update - Categoría no encontrada', ['id' => $id]);
            return false;
        }

        // DEBUG TEMPORAL - QUITAR DESPUÉS  
        Log::info('Service update - Datos a actualizar', $dto->toArray());
        Log::info('Service update - Estado antes', [
            'nombre_actual' => $categoria->nombre
        ]);

        $categoria->nombre = $dto->nombre;
        $result = $categoria->save();

        // DEBUG TEMPORAL - QUITAR DESPUÉS
        Log::info('Service update - Resultado', ['success' => $result]);
        if ($result) {
            $categoria->refresh();
            Log::info('Service update - Estado después', [
                'nombre_nuevo' => $categoria->nombre
            ]);
        }

        return $result;
    }

    /**
     * Eliminar categoría
     */
    public function delete(int $id): bool
    {
        $categoria = $this->findById($id);

        if (!$categoria) {
            return false;
        }

        return $categoria->delete();
    }

    /**
     * Verificar si el nombre ya existe
     */
    public function nombreExists(string $nombre, ?int $excludeId = null): bool
    {
        $query = $this->categoriaModel->where('nombre', $nombre);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
