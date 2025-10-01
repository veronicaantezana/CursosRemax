<template>
  <AdminLayout title="Editar Curso" subtitle="Actualiza la información del curso">
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Editar Curso</h1>
          <p class="text-gray-600">Actualiza la información del curso</p>
        </div>
        <Link href="/admin/cursos"
          class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
          <i class="pi pi-arrow-left"></i>
          Volver a cursos
        </Link>
      </div>

      <!-- Alertas -->
      <div v-if="$page.props.flash.success" class="p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div v-if="$page.props.flash.error" class="p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ $page.props.flash.error }}
      </div>

      <Card>
        <template #content>
          <form @submit.prevent="submit" class="space-y-6">
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
                class="w-full"
                :class="{ 'p-invalid': form.errors.categoria_id }"
              />
              <small v-if="form.errors.categoria_id" class="p-error">
                {{ form.errors.categoria_id }}
              </small>
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
                class="w-full"
                :class="{ 'p-invalid': form.errors.nombre }"
              />
              <small v-if="form.errors.nombre" class="p-error">
                {{ form.errors.nombre }}
              </small>
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
                class="w-full"
                :class="{ 'p-invalid': form.errors.descripcion }"
              />
              <small v-if="form.errors.descripcion" class="p-error">
                {{ form.errors.descripcion }}
              </small>
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
                class="w-full"
                :class="{ 'p-invalid': form.errors.imagen }"
              />
              <small v-if="form.errors.imagen" class="p-error">
                {{ form.errors.imagen }}
              </small>
            </div>

            <!-- Tiempo de Vigencia -->
            <div class="space-y-2">
              <label for="tiempoVigencia" class="block text-sm font-medium text-gray-700">
                Tiempo de Vigencia (días) *
              </label>
              <InputNumber
                id="tiempoVigencia"
                v-model="form.tiempoVigencia"
                class="w-full"
                :class="{ 'p-invalid': form.errors.tiempoVigencia }"
                :min="1"
                :max="365"
              />
              <small v-if="form.errors.tiempoVigencia" class="p-error">
                {{ form.errors.tiempoVigencia }}
              </small>
            </div>

            <!-- Calificación -->
            <div class="space-y-2">
              <label for="calificacion" class="block text-sm font-medium text-gray-700">
                Calificación (0-5)
              </label>
              <InputNumber
                id="calificacion"
                v-model="form.calificacion"
                class="w-full"
                :class="{ 'p-invalid': form.errors.calificacion }"
                :min="0"
                :max="5"
                :minFractionDigits="1"
                :maxFractionDigits="1"
              />
              <small v-if="form.errors.calificacion" class="p-error">
                {{ form.errors.calificacion }}
              </small>
            </div>

            <!-- Botones -->
            <div class="flex gap-3 pt-4">
              <Link 
                href="/admin/cursos"
                class="flex-1 p-button p-button-outlined p-button-secondary justify-center"
              >
                <i class="pi pi-times mr-2"></i>
                Cancelar
              </Link>
              <Button 
                type="submit" 
                :disabled="form.processing"
                class="flex-1 justify-center"
                :loading="form.processing"
              >
                <i class="pi pi-check mr-2" v-if="!form.processing"></i>
                {{ form.processing ? 'Actualizando...' : 'Actualizar Curso' }}
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
import { Link, useForm } from '@inertiajs/vue3'
import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import InputNumber from 'primevue/inputnumber'
import Dropdown from 'primevue/dropdown'

const props = defineProps({
  curso: {
    type: Object,
    required: true
  },
  categorias: {
    type: Array,
    required: true
  }
})

const form = useForm({
  categoria_id: props.curso.categoria_id,
  nombre: props.curso.nombre,
  descripcion: props.curso.descripcion || '',
  imagen: props.curso.imagen || '',
  tiempoVigencia: props.curso.tiempoVigencia,
  calificacion: props.curso.calificacion || null
})

const submit = () => {
  form.put(`/admin/cursos/${props.curso.id}`, {
    preserveScroll: true
  })
}
</script>