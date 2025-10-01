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

               await router.post('/login', credentials, {
                    onSuccess: (page) => {
                        this.user = page.props.auth?.user;
                        this.error = null;
                        console.log('Login exitoso con Inertia');
                        
                        // La redirección ya la maneja Laravel automáticamente
                        // No necesitas redirigir manualmente
                    },
                    onError: (errors) => {
                        // Manejar errores de validación de Laravel
                        if (errors.username) {
                            this.error = errors.username[0];
                        } else if (errors.password) {
                            this.error = errors.password[0];
                        } else {
                            this.error = errors.message || 'Credenciales incorrectas';
                        }
                        console.log('Errores de login:', errors);
                    }
                });

            } catch (error) {
                this.error = 'Error de conexión';
                console.error('Error en login:', error);
            } finally {
                this.loading = false;
            }
        },

           async logout() {
            try {
                // ✅ CAMBIO: Usar Inertia en lugar de fetch
                await router.post('/logout');
                this.user = null;
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
                this.user = null;
                router.visit('/login');
            }
        },
        /*getCsrfToken() {
          
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }

            // Laravel guarda el token 
            const cookieValue = document.cookie
                .split('; ')
                .find(row => row.startsWith('XSRF-TOKEN='))
                ?.split('=')[1];

            if (cookieValue) {
                return decodeURIComponent(cookieValue);
            }

            
            if (window.__INERTIA_CSRF_TOKEN) {
                return window.__INERTIA_CSRF_TOKEN;
            }

            console.warn('No se encontró token CSRF, intentando sin él');
            return '';
        },

        async logout() {
            try {
                const csrfToken = this.getCsrfToken();

                if (!csrfToken) {
                    console.error('No se pudo obtener el token CSRF');
                    
                    router.post('/logout');
                    return;
                }

                const response = await fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin' 
                });

                if (response.ok) {
                    this.user = null;
                    router.visit('/login');
                } else {
                    console.error('Error en logout:', response.status);
                    
                    router.visit('/login');
                }

            } catch (error) {
                console.error('Error al cerrar sesión:', error);
                this.user = null;
                router.visit('/login');
            }
        },

      
        async logoutWithInertia() {
            try {
                router.post('/logout');
            } catch (error) {
                console.error('Error al cerrar sesión:', error);
            }
        },*/

        initializeAuth() {
        
        }
    }
});