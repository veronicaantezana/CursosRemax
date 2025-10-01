<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalAuthService
{
    private string $apiBaseUrl = 'https://intramax.bo/api';

    public function authenticate(string $username, string $password): ?array
    {
        try {
            Log::debug(' ENVIANDO CREDENCIALES A API', [
                'username' => $username
            ]);

            $response = Http::timeout(10)->post("{$this->apiBaseUrl}/login", [
                'username' => $username,
                'password' => $password
            ]);

            Log::debug('📡 RESPUESTA BRUTA DE API', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Si la API devuelve status success
                if ($data['status'] === 'success') {

                   
                    // Caso 1: Datos directamente en el objeto principal (admin)
                    if (isset($data['user_id'])) {
                        Log::debug(' ESTRUCTURA ADMIN DETECTADA');
                        return [
                            'user_id' => $data['user_id'],
                            'username' => $data['username'],
                            'name_to_show' => $data['name_to_show'] ?? $data['name'] ?? $data['username'],
                            'first_name' => $data['first_name'] ?? '',
                            'last_name' => $data['last_name'] ?? '',
                            'role_id' => $data['role_id'],
                            'role' => $data['role']
                        ];
                    }

                    // Caso 2: Datos dentro de objeto 'user' (agente)
                    if (isset($data['user']) && is_array($data['user'])) {
                        Log::debug(' ESTRUCTURA AGENTE DETECTADA');
                        $userData = $data['user'];
                        return [
                            'user_id' => $userData['user_id'],
                            'username' => $userData['username'],
                            'name_to_show' => $userData['name_to_show'] ?? $userData['name'] ?? $userData['username'],
                            'first_name' => $userData['first_name'] ?? '',
                            'last_name' => $userData['last_name'] ?? '',
                            'role_id' => $userData['role_id'],
                            'role' => $userData['role']
                        ];
                    }

                    Log::error(' ESTRUCTURA DESCONOCIDA', $data);
                }
            }

            Log::warning('AUTENTICACIÓN FALLIDA');
            return null;
        } catch (\Exception $e) {
            Log::error(' ERROR EN EXTERNAL AUTH', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }
}
