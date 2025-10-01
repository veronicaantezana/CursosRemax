<?php

namespace App\DTOs;

class CursoDto
{
    public function __construct(
        public int $categoria_id,
        public string $nombre,
        public ?string $descripcion = null,
        public ?string $imagen = null,
        public int $tiempoVigencia,
        public ?float $calificacion = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            categoria_id: (int)$data['categoria_id'],
            nombre: $data['nombre'],
            descripcion: $data['descripcion'] ?? null,
            imagen: $data['imagen'] ?? null,
            tiempoVigencia: (int)$data['tiempoVigencia'],
            calificacion: isset($data['calificacion']) ? (float)$data['calificacion'] : null
        );
    }

    public function toArray(): array
    {
        return [
            'categoria_id' => $this->categoria_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'imagen' => $this->imagen,
            'tiempoVigencia' => $this->tiempoVigencia,
            'calificacion' => $this->calificacion
        ];
    }
}