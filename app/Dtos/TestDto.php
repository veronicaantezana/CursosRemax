<?php

namespace App\Dtos;

class TestDto
{
    public function __construct(
        public int $curso_id,
        public string $nombre,
        public ?string $descripcion = null,
        public ?int $duracion = null,
        public ?float $calificacion = null
       
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            curso_id: (int)$data['curso_id'],
            nombre: $data['nombre'],
            descripcion: $data['descripcion'] ?? null,
            duracion: isset($data['duracion']) ? (int)$data['duracion'] : null,
            calificacion: isset($data['calificacion']) ? (float)$data['calificacion'] : null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'curso_id' => $this->curso_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'duracion' => $this->duracion,
            'calificacion' => $this->calificacion
        ], function ($value) {
            return $value !== null;
        });
    }
}
