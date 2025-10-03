<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class MaterialDto
{
    public function __construct(
        public int $tema_id,
        public ?UploadedFile $archivo = null,
        public ?string $url = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            tema_id: (int)$data['tema_id'],
            archivo: $data['archivo'] ?? null,
            url: $data['url'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'tema_id' => $this->tema_id,
            'archivo' => $this->archivo,
            'url' => $this->url
        ];
    }

    public function tieneArchivo(): bool
    {
        return !is_null($this->archivo);
    }

    public function tieneUrl(): bool
    {
        return !is_null($this->url) && $this->url !== '';
    }
}