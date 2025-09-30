<template>
  <div class="admin-layout flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-4 border-b">
        <h1 class="text-xl font-bold text-gray-800">Panel Admin</h1>
      </div>

      <nav class="mt-6">
        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">Principal</div>
        <Link href="/admin/dashboard"
          class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
          :class="{ 'bg-blue-50 text-blue-600 border-r-2 border-blue-600': $page.url.startsWith('/admin/dashboard') }">
        <i class="pi pi-home mr-3"></i>
        Dashboard
        </Link>

        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">Gestión</div>
        <Link href="/admin/categorias"
          class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
          :class="{ 'bg-blue-50 text-blue-600 border-r-2 border-blue-600': $page.url.startsWith('/admin/categorias') }">
        <i class="pi pi-tags mr-3"></i>
        Categorías
        </Link>
        <Link href="/admin/cursos"
          class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"
          :class="{ 'bg-blue-50 text-blue-600 border-r-2 border-blue-600': $page.url.startsWith('/admin/cursos') }">
        <i class="pi pi-book mr-3"></i>
        Cursos
        </Link>
      </nav>
      <!-- Logout Button en el sidebar -->
      <div class="absolute bottom-0 w-64 p-4 border-t">
        <button @click="logout"
          class="flex items-center w-full px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors rounded-lg">
          <i class="pi pi-sign-out mr-3"></i>
          Cerrar Sesión
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <header class="bg-white shadow-sm border-b">
        <div class="flex items-center justify-between px-6 py-4">
          <div>
            <h2 class="text-lg font-semibold text-gray-900">{{ title }}</h2>
            <p class="text-sm text-gray-600">{{ subtitle }}</p>
          </div>
          <div class="flex items-center gap-4">
            <!-- Información del usuario CON VALIDACIÓN -->
            <div class="text-right" v-if="user">
              <span class="block text-sm font-medium text-gray-900">
                {{ user.name_to_show || user.username }}
              </span>
              <span class="block text-xs text-gray-600 capitalize">
                {{ user.role?.toLowerCase() || 'usuario' }}
              </span>
            </div>
            <!-- Botón de usuario -->
            <Button icon="pi pi-user" severity="secondary" text rounded />
            <!-- Botón de logout -->
            <Button icon="pi pi-sign-out" severity="danger" @click="logout" v-tooltip="'Cerrar sesión'"
              class="hover:bg-red-50">
              <span class="ml-2 text-sm">Salir</span>
            </Button>
          </div>
        </div>
      </header>

      <div class="p-6">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Button from 'primevue/button'
import { useAuthStore } from '@/stores/authStore'
import { computed } from 'vue'
const authStore = useAuthStore()
const user = computed(() => {
  if ($page.props.auth?.user) {
    return $page.props.auth.user
  }
  if (authStore.user) {
    return authStore.user
  }

  return null
})
defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  },
  subtitle: {
    type: String,
    default: 'Panel de administración'
  }
})
const logout = async () => {
  if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
    try {
      await authStore.logout()
      // El logout ya redirige automáticamente a /login desde el store
    } catch (error) {
      console.error('Error al cerrar sesión:', error)
    }
  }
}
</script>

<style scoped>
.admin-layout {
  font-family: 'Inter', sans-serif;
}
</style>