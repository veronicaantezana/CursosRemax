<?php

namespace App\DTOs;

class CategoriaDto
{
    public function __construct(
        public string $nombre
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            nombre: $data['nombre']
        );
    }

    public function toArray(): array
    {
        return [
            'nombre' => $this->nombre
        ];
    }
}