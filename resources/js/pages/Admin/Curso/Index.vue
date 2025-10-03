<template>
  <AdminLayout title="Cursos" subtitle="Gestiona los cursos del sistema">
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Cursos</h1>
          <p class="text-gray-600">{{ cursos.length }} cursos registrados</p>
        </div>
        <Link href="/admin/cursos/crear"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
        <i class="pi pi-plus"></i>
        Nuevo Curso
        </Link>
      </div>

      <Card>
        <template #content>
          <div v-if="cursos.length === 0" class="text-center py-8">
            <i class="pi pi-inbox text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">No hay cursos registrados</p>
            <Link href="/admin/cursos/crear"
              class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center gap-2">
            <i class="pi pi-plus"></i>
            Crear primer curso
            </Link>
          </div>

          <div v-else class="space-y-3">
            <div v-for="curso in cursos" :key="curso.id"
              class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
              <div class="flex-1">
                <h3 class="font-semibold text-gray-900">{{ curso.nombre }}</h3>
                <div class="flex gap-4 mt-2 text-sm text-gray-500">
                  <span class="flex items-center gap-1">
                    <i class="pi pi-tag"></i>
                    {{ curso.categoria?.nombre || 'Sin categoría' }}
                  </span>
                  <span class="flex items-center gap-1">
                    <i class="pi pi-calendar"></i>
                    {{ curso.tiempoVigencia }} días
                  </span>
                  <span v-if="curso.calificacion" class="flex items-center gap-1">
                    <i class="pi pi-star"></i>
                    {{ curso.calificacion }}/100
                  </span>
                </div>
                <p v-if="curso.descripcion" class="text-sm text-gray-600 mt-2 line-clamp-2">
                  {{ curso.descripcion }}
                </p>
              </div>

              <div class="flex flex-col items-start gap-2 mt-3">
                <div class="flex gap-2">
                  <Link :href="`/admin/cursos/${curso.id}/temas`"
                    class="p-button p-button-text p-button-sm text-green-600 hover:bg-blue-100">
                  Añadir Temas
                  </Link>
                  <Link :href="`/admin/cursos/${curso.id}/editar`"
                    class="p-button p-button-text p-button-sm text-blue-600 hover:bg-blue-100">
                  Editar
                  </Link>
                  <Button severity="danger" text @click="confirmDelete(curso)" class="hover:bg-red-100 text-red-600">
                    Eliminar
                  </Button>
                </div>
                  <Link :href="`/admin/cursos/${curso.id}/tests/crear`"
                    class="bg-blue-600 text-white px-3 py-1 text-sm rounded-md hover:bg-blue-700 transition-colors flex items-center gap-2">
                  <i class="pi pi-plus"></i>
                  Agregar Test
                  </Link>
                
              </div>
            </div>
          </div>
        </template>
      </Card>
    </div>

    <ConfirmDialog>
      <template #container="{ message, acceptCallback, rejectCallback }">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <!-- Header -->
            <div class="flex items-center gap-3 p-6 border-b border-gray-200">
              <div class="bg-red-100 p-2 rounded-full">
                <i class="pi pi-exclamation-triangle text-red-600 text-xl"></i>
              </div>
              <div>
                <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
                <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
              </div>
            </div>

            <div class="p-6">
              <p class="text-gray-700">{{ message.message }}</p>
            </div>

            <div class="flex gap-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-lg">
              <button @click="rejectCallback"
                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                Cancelar
              </button>
              <button @click="acceptCallback"
                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                Sí, eliminar
              </button>
            </div>
          </div>
        </div>
      </template>
    </ConfirmDialog>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import Card from 'primevue/card'
import Button from 'primevue/button'
import { useConfirm } from "primevue/useconfirm"
import ConfirmDialog from 'primevue/confirmdialog'

const confirm = useConfirm()

defineProps({
  cursos: {
    type: Array,
    required: true
  }
})

const confirmDelete = (curso) => {
  confirm.require({
    message: `¿Estás seguro de eliminar el curso "${curso.nombre}"?`,
    header: 'Confirmar eliminación',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Sí, eliminar',
    rejectLabel: 'Cancelar',
    accept: () => {
      router.delete(`/admin/cursos/${curso.id}`, {
        preserveScroll: true
      })
    }
  })
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>