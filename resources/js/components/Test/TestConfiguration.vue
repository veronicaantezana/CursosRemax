<template>
  <div class="space-y-6">
    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Configuración del Test</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Intentos permitidos -->
      <div class="space-y-2">
        <label for="intentos_permitidos" class="block text-sm font-medium text-gray-700">
          Intentos Permitidos
        </label>
        <InputNumber
          id="intentos_permitidos"
          v-model="modelValueIntentos"
          class="w-full custom-inputnumber"
          :min="1"
          :max="10"
        />
        <p class="text-xs text-gray-500">Número de veces que se puede intentar el test</p>
      </div>

      <!-- Mostrar resultados -->
      <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Mostrar Resultados
        </label>
        <div class="flex items-center gap-3">
          <ToggleSwitch v-model="modelValueMostrarResultados" />
          <span class="text-sm text-gray-600">
            {{ modelValueMostrarResultados ? 'Sí' : 'No' }}
          </span>
        </div>
        <p class="text-xs text-gray-500">Mostrar puntaje y respuestas al finalizar</p>
      </div>
    </div>

    <!-- Aleatorizar preguntas -->
    <div class="space-y-2">
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Aleatorizar Preguntas
      </label>
      <div class="flex items-center gap-3">
        <ToggleSwitch v-model="modelValueAleatorizar" />
        <span class="text-sm text-gray-600">
          {{ modelValueAleatorizar ? 'Sí' : 'No' }}
        </span>
      </div>
      <p class="text-xs text-gray-500">Mostrar preguntas en orden aleatorio</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import InputNumber from 'primevue/inputnumber'
import ToggleSwitch from 'primevue/toggleswitch';

const props = defineProps({
  intentosPermitidos: Number,
  mostrarResultados: Boolean,
  aleatorizarPreguntas: Boolean
})

const emit = defineEmits([
  'update:intentosPermitidos',
  'update:mostrarResultados', 
  'update:aleatorizarPreguntas'
])

const modelValueIntentos = computed({
  get: () => props.intentosPermitidos,
  set: (value) => emit('update:intentosPermitidos', value)
})

const modelValueMostrarResultados = computed({
  get: () => props.mostrarResultados,
  set: (value) => emit('update:mostrarResultados', value)
})

const modelValueAleatorizar = computed({
  get: () => props.aleatorizarPreguntas,
  set: (value) => emit('update:aleatorizarPreguntas', value)
})
</script>