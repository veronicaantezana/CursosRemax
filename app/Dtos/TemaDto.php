<?php

namespace App\DTOs;

class TemaDto
{
    public function __construct(
        public int $curso_id,
        public string $nombre,
        public int $duracion,
        public ?string $archivo_path = null,
        public ?string $url = null,
        public ?string $tipo_archivo = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            curso_id: isset($data['curso_id']) ? (int)$data['curso_id'] : null,
            nombre: $data['nombre'],
            duracion: (int)$data['duracion'],
            archivo_path: $data['archivo_path'] ?? null,
            url: $data['url'] ?? null,
            tipo_archivo: $data['tipo_archivo'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'nombre' => $this->nombre,
            'duracion' => $this->duracion,
            'archivo_path' => $this->archivo_path,
            'url' => $this->url,
            'tipo_archivo' => $this->tipo_archivo,
            'curso_id' => $this->curso_id 
        ], function ($value) {
            return $value !== null;
        });
    }
}
