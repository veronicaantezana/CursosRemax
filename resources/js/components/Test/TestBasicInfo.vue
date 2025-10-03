<template>
  <div class="space-y-6">
    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Información Básica</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <!-- Nombre -->
      <div class="space-y-2">
        <label for="nombre" class="block text-sm font-medium text-gray-700">
          Nombre del Test *
        </label>
        <InputText
          id="nombre"
          v-model="modelValueNombre"
          type="text"
          class="w-full custom-input"
          :class="errors?.nombre ? 'border-red-500' : ''"
          placeholder="Ej: Evaluación Final"
        />
        <p v-if="errors?.nombre" class="text-red-600 text-sm mt-1">
          {{ errors.nombre }}
        </p>
      </div>

      <!-- Duración -->
      <div class="space-y-2">
        <label for="duracion" class="block text-sm font-medium text-gray-700">
          Duración (minutos) *
        </label>
        <InputNumber
          id="duracion"
          v-model="modelValueDuracion"
          class="w-full custom-inputnumber"
          :class="errors?.duracion ? 'border-red-500' : ''"
          placeholder="30"
          :min="5"
          :max="180"
        />
        <p v-if="errors?.duracion" class="text-red-600 text-sm mt-1">
          {{ errors.duracion }}
        </p>
      </div>
    </div>

    <!-- Descripción -->
    <div class="space-y-2">
      <label for="descripcion" class="block text-sm font-medium text-gray-700">
        Descripción
      </label>
      <Textarea
        id="descripcion"
        v-model="modelValueDescripcion"
        class="w-full custom-textarea"
        :class="errors?.descripcion ? 'border-red-500' : ''"
        placeholder="Describe el objetivo del test..."
        rows="3"
      />
      <p v-if="errors?.descripcion" class="text-red-600 text-sm mt-1">
        {{ errors.descripcion }}
      </p>
    </div>

    <!-- Calificación mínima -->
    <div class="space-y-2 max-w-xs">
      <label for="calificacion" class="block text-sm font-medium text-gray-700">
        Calificación Mínima para Aprobar (%) *
      </label>
      <InputNumber
        id="calificacion"
        v-model="modelValueCalificacion"
        class="w-full custom-inputnumber"
        :class="errors?.calificacion ? 'border-red-500' : ''"
        placeholder="70"
        :min="0"
        :max="100"
        suffix="%"
      />
      <p v-if="errors?.calificacion" class="text-red-600 text-sm mt-1">
        {{ errors.calificacion }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Textarea from 'primevue/textarea'

const props = defineProps({
  nombre: String,
  descripcion: String,
  duracion: Number,
  calificacion: Number,
  errors: Object
})

const emit = defineEmits([
  'update:nombre',
  'update:descripcion', 
  'update:duracion',
  'update:calificacion'
])

const modelValueNombre = computed({
  get: () => props.nombre,
  set: (value) => emit('update:nombre', value)
})

const modelValueDescripcion = computed({
  get: () => props.descripcion,
  set: (value) => emit('update:descripcion', value)
})

const modelValueDuracion = computed({
  get: () => props.duracion,
  set: (value) => emit('update:duracion', value)
})

const modelValueCalificacion = computed({
  get: () => props.calificacion,
  set: (value) => emit('update:calificacion', value)
})
</script>

<style scoped>
:deep(.custom-input .p-inputtext) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  background: white;
  width: 100%;
}

:deep(.custom-inputnumber .p-inputnumber-input) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 0.75rem;
  background: white;
  width: 100%;
}

:deep(.custom-textarea .p-textarea) {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  background: white;
  width: 100%;
}
</style>