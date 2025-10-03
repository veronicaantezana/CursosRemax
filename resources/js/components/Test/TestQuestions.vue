<template>
    <div class="space-y-6">
        <div class="flex justify-between items-center border-b pb-2">
            <h3 class="text-lg font-semibold text-gray-900">Preguntas</h3>
            <Button @click="$emit('addQuestion')"
                class="bg-green-600 text-white px-3 py-2 text-sm rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="pi pi-plus"></i>
                Agregar Pregunta
            </Button>
        </div>

        <div v-if="errors?.preguntas" class="p-3 bg-red-50 border border-red-200 rounded-lg">
            <p class="text-red-700 text-sm">{{ errors.preguntas }}</p>
        </div>

        <!-- Lista de preguntas -->
        <div v-for="(pregunta, index) in modelValuePreguntas" :key="index"
            class="border border-gray-200 rounded-lg p-4 space-y-4">

            <!-- Header de pregunta -->
            <div class="flex justify-between items-center">
                <h4 class="font-medium text-gray-900">Pregunta {{ index + 1 }}</h4>
                <Button v-if="modelValuePreguntas.length > 1" @click="$emit('removeQuestion', index)" severity="danger"
                    text class="p-1 hover:bg-red-100" title="Eliminar pregunta">
                    <i class="pi pi-trash text-xs"></i>
                </Button>
            </div>

            <!-- Enunciado -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Enunciado *
                </label>
                <Textarea v-model="pregunta.enunciado" class="w-full custom-textarea"
                    placeholder="Escribe la pregunta aquí..." rows="2" />
            </div>

            <!-- Tipo de pregunta -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Tipo de Pregunta
                </label>
                <select v-model="pregunta.tipo"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="seleccion_unica">Selección Única</option>
                    <option value="seleccion_multiple">Selección Múltiple</option>
                    <option value="verdadero_falso">Verdadero/Falso</option>
                    <option value="respuesta_corta">Respuesta Corta</option>
                    <option value="respuesta_larga">Respuesta Larga</option>
                </select>
            </div>

            <div v-if="pregunta.tipo === 'seleccion_multiple'" class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">
                    Opciones de Respuesta
                </label>

                <div v-for="(opcion, opcionIndex) in pregunta.opciones" :key="opcionIndex"
                    class="flex items-center gap-3">
                    <InputText v-model="opcion.texto" class="flex-1 custom-input"
                        :placeholder="`Opción ${opcionIndex + 1}`" />
                    <div class="flex items-center gap-2">
                        <ToggleSwitch v-model="opcion.es_correcta" />
                        <span class="text-sm text-gray-600 whitespace-nowrap">Correcta</span>
                    </div>
                </div>
            </div>

            <!-- Puntaje -->
            <div class="space-y-2 max-w-xs">
                <label class="block text-sm font-medium text-gray-700">
                    Puntaje
                </label>
                <InputNumber v-model="pregunta.puntaje" class="w-full custom-inputnumber" :min="1" :max="10" />
            </div>
        </div>

        <!-- Mensaje si no hay preguntas -->
        <div v-if="modelValuePreguntas.length === 0"
            class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
            <i class="pi pi-inbox text-4xl text-gray-400 mb-3"></i>
            <p class="text-gray-500">No hay preguntas agregadas</p>
            <p class="text-sm text-gray-400 mt-1">Agrega al menos una pregunta para crear el test</p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import Button from 'primevue/button'
import Textarea from 'primevue/textarea'
import InputText from 'primevue/inputtext'
import ToggleSwitch from 'primevue/toggleswitch';
import InputNumber from 'primevue/inputnumber'

const emit = defineEmits(['addQuestion', 'removeQuestion'])

const props = defineProps({
    preguntas: Array,
    errors: Object
})

const modelValuePreguntas = computed({
    get: () => props.preguntas,
    set: (value) => emit('update:preguntas', value)
})

const tiposPregunta = [
    { label: 'Opción Múltiple', value: 'multiple' },
    { label: 'Verdadero/Falso', value: 'verdadero_falso' },
    { label: 'Respuesta Corta', value: 'respuesta_corta' },
    { label: 'Respuesta Larga', value: 'respuesta_larga' }
]
</script>