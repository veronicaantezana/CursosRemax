<template>
  <AdminLayout title="Crear Curso" subtitle="Agrega un nuevo curso al sistema">
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Crear Nuevo Curso</h1>
          <p class="text-gray-600">Completa la información del curso</p>
        </div>
        <Link href="/admin/cursos"
          class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
          <i class="pi pi-arrow-left"></i>
          Volver a cursos
        </Link>
      </div>

      <!-- Alertas -->
      <div v-if="flashSuccess" class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ flashSuccess }}
      </div>

      <div v-if="flashError" class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ flashError }}
      </div>

      <Card class="shadow-lg border border-gray-200">
        <template #content>
          <form @submit.prevent="submit" class="space-y-6 p-6">
            <!-- Categoría -->
            <div class="space-y-2">
              <label for="categoria_id" class="block text-sm font-medium text-gray-700">
                Categoría *
              </label>
              <Dropdown 
                v-model="form.categoria_id"
                :options="categorias"
                optionLabel="nombre"
                optionValue="id"
                placeholder="Selecciona una categoría"
                class="w-full custom-dropdown"
                :class="form.errors.categoria_id ? 'border-red-500' : ''"
                showClear
              />
              <p v-if="form.errors.categoria_id" class="text-red-600 text-sm mt-1">
                {{ form.errors.categoria_id }}
              </p>
            </div>

            <!-- Nombre -->
            <div class="space-y-2">
              <label for="nombre" class="block text-sm font-medium text-gray-700">
                Nombre del Curso *
              </label>
              <InputText
                id="nombre"
                v-model="form.nombre"
                type="text"
                class="w-full custom-input"
                :class="form.errors.nombre ? 'border-red-500' : ''"
                placeholder="Ej: Marketing Digital Avanzado"
              />
              <p v-if="form.errors.nombre" class="text-red-600 text-sm mt-1">
                {{ form.errors.nombre }}
              </p>
            </div>

            <!-- Descripción -->
            <div class="space-y-2">
              <label for="descripcion" class="block text-sm font-medium text-gray-700">
                Descripción
              </label>
              <Textarea
                id="descripcion"
                v-model="form.descripcion"
                rows="4"
                class="w-full custom-textarea"
                :class="form.errors.descripcion ? 'border-red-500' : ''"
                placeholder="Describe el contenido del curso, objetivos, etc."
              />
              <p v-if="form.errors.descripcion" class="text-red-600 text-sm mt-1">
                {{ form.errors.descripcion }}
              </p>
            </div>

            <!-- Imagen -->
            <div class="space-y-2">
              <label for="imagen" class="block text-sm font-medium text-gray-700">
                URL de la Imagen
              </label>
              <InputText
                id="imagen"
                v-model="form.imagen"
                type="text"
                class="w-full custom-input"
                :class="form.errors.imagen ? 'border-red-500' : ''"
                placeholder="https://ejemplo.com/imagen-curso.jpg"
              />
              <p v-if="form.errors.imagen" class="text-red-600 text-sm mt-1">
                {{ form.errors.imagen }}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                Puedes usar enlaces de imágenes de Unsplash, Cloudinary, o subir la imagen a tu servidor.
              </p>
            </div>

            <!-- Tiempo de Vigencia -->
            <div class="space-y-2">
              <label for="tiempoVigencia" class="block text-sm font-medium text-gray-700">
                Tiempo de Vigencia (días) *
              </label>
              <InputNumber
                id="tiempoVigencia"
                v-model="form.tiempoVigencia"
                class="w-full custom-inputnumber"
                :class="form.errors.tiempoVigencia ? 'border-red-500' : ''"
                placeholder="30"
                :min="1"
                :max="365"
              />
              <p v-if="form.errors.tiempoVigencia" class="text-red-600 text-sm mt-1">
                {{ form.errors.tiempoVigencia }}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                Número de días que estará disponible el curso para los estudiantes.
              </p>
            </div>

            <!-- Calificación -->
            <div class="space-y-2">
              <label for="calificacion" class="block text-sm font-medium text-gray-700">
                Calificación (0-5)
              </label>
              <InputNumber
                id="calificacion"
                v-model="form.calificacion"
                class="w-full custom-inputnumber"
                :class="form.errors.calificacion ? 'border-red-500' : ''"
                placeholder="4.5"
                :min="0"
                :max="5"
                :minFractionDigits="1"
                :maxFractionDigits="1"
              />
              <p v-if="form.errors.calificacion" class="text-red-600 text-sm mt-1">
                {{ form.errors.calificacion }}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                Calificación inicial del curso (opcional). Puede ser actualizada posteriormente.
              </p>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-4">
              <Link 
                href="/admin/cursos"
                class="flex-1 bg-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center gap-2 font-medium"
              >
                <i class="pi pi-times"></i>
                Cancelar
              </Link>
              <Button 
                type="submit" 
                :disabled="form.processing"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-medium disabled:opacity-50"
              >
                <i class="pi pi-check" v-if="!form.processing"></i>
                <i class="pi pi-spinner pi-spin" v-if="form.processing"></i>
                {{ form.processing ? 'Creando...' : 'Crear Curso' }}
              </Button>
            </div>
          </form>
        </template>
      </Card>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import InputNumber from 'primevue/inputnumber'
import Dropdown from 'primevue/dropdown'

const page = usePage()

// Computed properties para flash messages
const flashSuccess = computed(() => page.props.flash?.success)
const flashError = computed(() => page.props.flash?.error)

const props = defineProps({
  categorias: {
    type: Array,
    required: true
  }
})

const form = useForm({
  categoria_id: null,
  nombre: '',
  descripcion: '',
  imagen: '',
  tiempoVigencia: null,
  calificacion: null
})

const submit = () => {
  form.post('/admin/cursos', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
    }
  })
}
</script>

<style scoped>
/* Estilos mejorados para los componentes PrimeVue */
:deep(.custom-dropdown .p-dropdown) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  background: white;
  width: 100%;
  transition: all 0.2s;
}

:deep(.custom-dropdown .p-dropdown:not(.p-disabled):hover) {
  border-color: #3b82f6;
}

:deep(.custom-dropdown .p-dropdown:not(.p-disabled).p-focus) {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

:deep(.custom-dropdown .p-dropdown-panel) {
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  background: white;
}

:deep(.custom-dropdown .p-dropdown-items .p-dropdown-item) {
  padding: 0.75rem 1rem;
  color: #374151;
  transition: all 0.2s;
}

:deep(.custom-dropdown .p-dropdown-items .p-dropdown-item.p-highlight) {
  background: #3b82f6;
  color: white;
}

:deep(.custom-dropdown .p-dropdown-items .p-dropdown-item:not(.p-highlight):not(.p-disabled):hover) {
  background: #f3f4f6;
  color: #374151;
}

:deep(.custom-input .p-inputtext) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  background: white;
  width: 100%;
  transition: all 0.2s;
}

:deep(.custom-input .p-inputtext:enabled:hover) {
  border-color: #9ca3af;
}

:deep(.custom-input .p-inputtext:enabled:focus) {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

:deep(.custom-textarea .p-inputtextarea) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  background: white;
  width: 100%;
  transition: all 0.2s;
  resize: vertical;
}

:deep(.custom-textarea .p-inputtextarea:enabled:hover) {
  border-color: #9ca3af;
}

:deep(.custom-textarea .p-inputtextarea:enabled:focus) {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

:deep(.custom-inputnumber .p-inputnumber) {
  width: 100%;
}

:deep(.custom-inputnumber .p-inputnumber-input) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  background: white;
  width: 100%;
  transition: all 0.2s;
}

:deep(.custom-inputnumber .p-inputnumber-input:enabled:hover) {
  border-color: #9ca3af;
}

:deep(.custom-inputnumber .p-inputnumber-input:enabled:focus) {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
}

:deep(.p-button) {
  border: none;
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  font-weight: 500;
  transition: all 0.2s;
}

:deep(.p-card) {
  border-radius: 0.75rem;
}

:deep(.p-card-content) {
  padding: 0;
}

/* Estilos para errores */
:deep(.border-red-500) {
  border-color: #ef4444 !important;
}

:deep(.border-red-500:focus) {
  box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
}
</style>