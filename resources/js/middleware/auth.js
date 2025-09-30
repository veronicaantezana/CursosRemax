import { useAuthStore } from '@/stores/authStore';

export default function auth({ next }) {
    const authStore = useAuthStore();
    
    authStore.initializeAuth();
    
    if (!authStore.isAuthenticated) {
        return next('/login');
    }
    
    return next();
}

export function adminAuth({ next }) {
    const authStore = useAuthStore();
    authStore.initializeAuth();
    
    if (!authStore.isAuthenticated) {
        return next('/login');
    }
    
    if (!authStore.isAdmin) {
        return next('/unauthorized');
    }
    
    return next();
}