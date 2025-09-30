import { router } from '@inertiajs/vue3';

const API_BASE_URL = 'https://intramax.bo/api';

class AuthService {
    async login(credentials) {
        try {
            const response = await fetch(`${API_BASE_URL}/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(credentials)
            });

            console.log('Respuesta HTTP:', response.status, response.statusText);
            if (!response.ok) {
                throw new Error('Error en la conexión con el servidor');
            }

            const data = await response.json();
            console.log('✅ Datos recibidos:', data);
            
            return data;
            
        } catch (error) {
            console.error('Error en login:', error);
            throw error;
        }
    }

    // Guardar datos de usuario en localStorage
    setUserData(userData) {
        localStorage.setItem('user', JSON.stringify(userData));
        localStorage.setItem('token_timestamp', Date.now().toString());
    }

    // Obtener datos del usuario
    getUserData() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }

    
    isTokenValid() {
        const timestamp = localStorage.getItem('token_timestamp');
        if (!timestamp) return false;
        
        // Considerar el token válido por 24 horas
        const HOURS_24 = 24 * 60 * 60 * 1000;
        return (Date.now() - parseInt(timestamp)) < HOURS_24;
    }

    // Cerrar sesión
    logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('token_timestamp');
        router.visit('/login');
    }
}

export default new AuthService();