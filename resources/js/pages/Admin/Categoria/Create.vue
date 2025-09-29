<template>
  <AdminLayout title="Crear Categoría" subtitle="Añade una nueva categoría de cursos">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

      <div v-if="$page.props?.flash?.success"
        class="p-4 mb-6 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        <i class="pi pi-check-circle mr-2"></i>
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props?.flash?.error" class="p-4 mb-6 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <i class="pi pi-exclamation-triangle mr-2"></i>
        {{ $page.props.flash.error }}
      </div>

      <Card>
        <template #title>
          <div class="flex items-center gap-2">
            <i class="pi pi-plus text-green-500"></i>
            <span>Nueva Categoría</span>
          </div>
        </template>

        <template #content>
          <form @submit.prevent="submitForm">
            <div class="field mb-6">
              <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                <label for="nombre" class="text-sm font-medium text-gray-700 whitespace-nowrap sm:min-w-48">
                  Nombre de la categoría <span class="text-red-500">*</span>
                </label>

                <div class="flex-1 w-full">
                  <input id="nombre" v-model="form.nombre" type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    :class="{ 'border-red-500': form.errors.nombre }" placeholder="Ej: Marketing Digital"
                    :disabled="form.processing" />
                  <small v-if="form.errors.nombre" class="p-error block mt-1">{{ form.errors.nombre }}</small>
                  <small v-else class="text-gray-500 text-xs block mt-1">
                    Ingresa el nombre de la nueva categoría
                  </small>
                </div>
              </div>
            </div>

            <!-- Botones responsive -->
            <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-gray-200">
              <Button type="button"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 border border-red-500 text-red-500 rounded-lg hover:bg-red-50 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="form.processing" @click="cancelar">
                <i class="pi pi-times"></i>
                Cancelar
              </Button>

              <button type="submit"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="form.processing || !form.nombre.trim()">
                <i class="pi pi-check" v-if="!form.processing"></i>
                <i class="pi pi-spinner pi-spin" v-else></i>
                {{ form.processing ? 'Creando...' : 'Crear Categoría' }}
              </button>
            </div>
          </form>
        </template>
      </Card>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, router } from '@inertiajs/vue3'
import Card from 'primevue/card'

import Button from 'primevue/button'

const form = useForm({
  nombre: ''
})

const submitForm = () => {
  form.post('/admin/categorias', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    },
    onError: (errors) => {
      console.log('Errores:', errors)
    }
  })
}

const cancelar = () => {
  router.visit('/admin/categorias')
}
</script>

<style scoped>
.p-button-success {
  background: #10b981 !important;
  border-color: #10b981 !important;
  font-weight: 600;
  color: white;
  border-radius: 10px;
}

.p-button-success:hover:not(:disabled) {
  background: #059669 !important;
  border-color: #059669 !important;
  color: #fef2f2;
  font-weight: bold;
}

.p-button-danger {
  color: #ef4444 !important;
  border-color: #ef4444 !important;
  border-radius: 10px;
}


.p-button-danger:hover:not(:disabled) {
  background: #fef2f2 !important;
}

:deep(.p-inputtext) {
  border: 1px solid black !important;
  border-radius: 4px;
}

:deep(.p-inputtext::placeholder) {
  
  color: #a0a0a0 !important;
}

/* Ajustes para móviles */
@media (max-width: 640px) {
  :deep(.p-button) {
    padding: 0.75rem 1rem;
  }

  :deep(.p-card .p-card-content) {
    padding: 1rem;
  }
}
</style>