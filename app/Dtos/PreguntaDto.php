<?php

namespace App\DTOs;

class PreguntaDto
{
    public function __construct(
        public int $test_id,
        public string $enunciado,
        public string $tipo,
        public int $orden = 0,
        public array $opciones = []
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            test_id: (int)$data['test_id'],
            enunciado: $data['enunciado'],
            tipo: $data['tipo'],
            orden: (int)($data['orden'] ?? 0),
            opciones: $data['opciones'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'test_id' => $this->test_id,
            'enunciado' => $this->enunciado,
            'tipo' => $this->tipo,
            'orden' => $this->orden
        ];
    }
}