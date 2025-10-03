<?php

namespace App\Services;

use App\DTOs\MaterialDto;
use App\Models\Material;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    public function __construct(
        private Material $materialModel
    ) {}

    /**
     * Obtener material por ID
     */
    public function findById(int $id): ?Material
    {
        Log::info('Buscando material por ID', ['id' => $id]);
        $material = $this->materialModel->find($id);
        Log::info('Resultado búsqueda material', ['encontrado' => !is_null($material)]);
        return $material;
    }

    /**
     * Crear material
     */
    public function create(MaterialDto $dto): Material
    {
        Log::info('Service create material - Iniciando', [
            'tema_id' => $dto->tema_id,
            'tiene_archivo' => $dto->tieneArchivo(),
            'tiene_url' => $dto->tieneUrl()
        ]);

        $material = new Material();
        $material->tema_id = $dto->tema_id;

        if ($dto->tieneArchivo()) {
            Log::info('Subiendo archivo material', [
                'nombre_original' => $dto->archivo->getClientOriginalName(),
                'tamaño' => $dto->archivo->getSize()
            ]);

            $path = $dto->archivo->store('materiales', 'public');
            $material->archivo_path = $path;
            $material->tipo = $material->detectarTipo($dto->archivo);

            Log::info('Archivo subido exitosamente', [
                'path' => $path,
                'tipo_detectado' => $material->tipo
            ]);
        }

        if ($dto->tieneUrl()) {
            Log::info('Guardando URL de video', ['url' => $dto->url]);
            $material->url = $dto->url;
            $material->tipo = 'video';
        }

        $material->save();
        Log::info('Material creado exitosamente', ['material_id' => $material->id]);

        return $material;
    }

    public function delete(int $id): bool
    {
        $material = $this->findById($id);

        if (!$material) {
            Log::warning('Material no encontrado para eliminar', ['id' => $id]);
            return false;
        }

        
        if ($material->archivo_path && Storage::disk('public')->exists($material->archivo_path)) {
            Log::info('Eliminando archivo físico', ['path' => $material->archivo_path]);
            Storage::disk('public')->delete($material->archivo_path);
        }

        $result = $material->delete();
        Log::info('Material eliminado', ['id' => $id, 'success' => $result]);

        return $result;
    }

    public function getByTema(int $temaId)
    {
        return $this->materialModel
            ->where('tema_id', $temaId)
            ->orderBy('id')
            ->get();
    }

    public function temaTieneMateriales(int $temaId): bool
    {
        return $this->materialModel->where('tema_id', $temaId)->exists();
    }


    public function countByTema(int $temaId): int
    {
        return $this->materialModel->where('tema_id', $temaId)->count();
    }
}