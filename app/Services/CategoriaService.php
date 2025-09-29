<?php

namespace App\Services;

use App\DTOs\CategoriaDto;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function findById(int $id): ?Categoria
    {
        return $this->categoriaModel->find($id);
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
        $categoria = $this->findById($id);
        
        if (!$categoria) {
            return false;
        }

        return $categoria->update($dto->toArray());
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