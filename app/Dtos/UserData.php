<?php

namespace App\DTos;

use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public int $user_id,
        public string $username,
        public string $name_to_show,
        public ?string $first_name,
        public ?string $last_name,
        public int $role_id,
        public string $role
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            username: $data['username'],
            name_to_show: $data['name_to_show'],
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            role_id: $data['role_id'],
            role: $data['role']
        );
    }
}