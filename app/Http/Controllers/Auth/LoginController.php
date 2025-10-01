<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ExternalAuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function __construct(
        private ExternalAuthService $externalAuthService
    ) {}

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        try {
            // 1. Verificar credenciales con API externa
            $authData = $this->externalAuthService->authenticate(
                $request->username, 
                $request->password
            );

            if (!$authData) {
                  return back()->withErrors([
                    'username' => 'Credenciales incorrectas'
                ]);
            }

            // 3. Sincronizar usuario en base de datos local
            $user = User::updateOrCreate(
                ['external_id' => $authData['user_id']],
                [
                    'username' => $authData['username'],
                    'name_to_show' => $authData['name_to_show'],
                    'first_name' => $authData['first_name'] ?? '',
                    'last_name' => $authData['last_name'] ?? '',
                    'role_id' => $authData['role_id'],
                    'role' => $authData['role'],
                ]
            );

            // 4. Autenticar usuario en Laravel
            Auth::login($user);

            Log::info('Usuario autenticado correctamente', [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'username' => $user->username
            ]);

             //return Inertia::location($this->getRedirectPath($user->role_id));
 return redirect($this->getRedirectPath($user->role_id));
        } catch (\Exception $e) {
            Log::error('Error en proceso de login', [
                'username' => $request->username,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors([
                'message' => 'Error interno del servidor'
            ]);
        }
    }

    private function getRedirectPath($roleId): string
    {
        return match($roleId) {
            2 => '/admin/dashboard', // Admin
            4 => '/', // Agente
            default => '/'
        };
    }

    public function logout(Request $request)
    { Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        
       // return Inertia::location('/login');
       return redirect('/login');
    }
}