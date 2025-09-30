import { defineStore } from 'pinia';
import { router } from '@inertiajs/vue3';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
        error: null
    }),

    getters: {
        isAuthenticated: (state) => !!state.user,
        isAdmin: (state) => state.user?.role_id === 2,
        userName: (state) => state.user?.name_to_show || state.user?.username
    },

    actions: {
        async login(credentials) {
            this.loading = true;
            this.error = null;

            try {
                console.log('Enviando credenciales al backend...');

                const csrfToken = this.getCsrfToken();
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(credentials)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'Error en la autenticación');
                }

                if (data.status === 'success') {
                    this.user = data.user;
                    this.error = null;
                    
                    // Redirigir según lo que indique el backend
                    if (data.redirect_to) {
                        console.log('Redirigiendo a:', data.redirect_to);
                        router.visit(data.redirect_to);
                    }
                    
                    return true;
                } else {
                    throw new Error(data.error || 'Credenciales incorrectas');
                }

            } catch (error) {
                this.error = error.message;
                return false;
            } finally {
                this.loading = false;
            }
        },

        getCsrfToken() {
            // Método 1: Buscar en meta tag
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }

            // Método 2: Buscar en cookies (Laravel guarda el token aquí)
            const cookieValue = document.cookie
                .split('; ')
                .find(row => row.startsWith('XSRF-TOKEN='))
                ?.split('=')[1];
            
            if (cookieValue) {
                return decodeURIComponent(cookieValue);
            }

            // Método 3: Usar el token de Inertia si está disponible
            if (window.__INERTIA_CSRF_TOKEN) {
                return window.__INERTIA_CSRF_TOKEN;
            }

            console.warn('No se encontró token CSRF, intentando sin él');
            return '';
        },

        async logout() {
            try {
                await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                this.user = null;
                router.visit('/login');
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        },

        initializeAuth() {
            // El backend ya maneja la sesión via cookies/Laravel Auth
            // Inertia se encargará de pasar el usuario automáticamente
        }
    }
});