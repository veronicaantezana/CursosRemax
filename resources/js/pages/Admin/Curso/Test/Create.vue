<template>
  <AdminLayout :title="`Crear Test - ${curso.nombre}`" subtitle="Crea un test para el curso">
    <div class="space-y-6">

      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Crear Test</h1>
          <p class="text-gray-600">Crea un nuevo test para el curso: {{ curso.nombre }}</p>
        </div>
        <Link :href="`/admin/cursos`" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
          <i class="pi pi-arrow-left"></i>
          Volver a cursos
        </Link>
      </div>

      <AlertMessages :success="flashSuccess" :error="flashError" />

      <Card class="shadow-lg border border-gray-200">
        <template #content>
          <form @submit.prevent="submit" class="space-y-6 p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
              <h3 class="font-semibold text-blue-900 mb-2">Curso: {{ curso.nombre }}</h3>
              <p class="text-sm text-blue-700">{{ curso.descripcion }}</p>
            </div>


            <TestBasicInfo
              v-model:nombre="form.nombre"
              v-model:descripcion="form.descripcion"
              v-model:duracion="form.duracion"
              v-model:calificacion="form.calificacion"
              :errors="form.errors"
            />

            <TestConfiguration
              v-model:intentosPermitidos="form.intentos_permitidos"
              v-model:mostrarResultados="form.mostrar_resultados"
              v-model:aleatorizarPreguntas="form.aleatorizar_preguntas"
            />

            <TestQuestions
              v-model:preguntas="form.preguntas"
              :errors="form.errors"
              @add-question="addQuestion"
              @remove-question="removeQuestion"
            />

            <div class="flex gap-3 pt-6 border-t border-gray-200">
              <Button 
                type="button"
                @click="cancel"
                class="flex-1 bg-gray-300 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center gap-2 font-medium"
              >
                <i class="pi pi-times"></i>
                Cancelar
              </Button>
              <Button 
                type="submit" 
                :disabled="form.processing"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors flex items-center justify-center gap-2 font-medium disabled:opacity-50"
              >
                <i class="pi pi-check" v-if="!form.processing"></i>
                <i class="pi pi-spinner pi-spin" v-if="form.processing"></i>
                {{ form.processing ? 'Creando...' : 'Crear Test' }}
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
import { Link, useForm, usePage, router } from '@inertiajs/vue3'
import { computed } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import AlertMessages from '@/Components/AlertMessages.vue'
import TestBasicInfo from '@/Components/Test/TestBasicInfo.vue'
import TestConfiguration from '@/Components/Test/TestConfiguration.vue'
import TestQuestions from '@/Components/Test/TestQuestions.vue'


const page = usePage()

const flashSuccess = computed(() => page.props.flash?.success)
const flashError = computed(() => page.props.flash?.error)

const props = defineProps({
  curso: {
    type: Object,
    required: true
  }
})

const form = useForm({
  nombre: '',
  descripcion: '',
  duracion: 30,
  calificacion: 70,
  intentos_permitidos: 1,
  mostrar_resultados: true,
  aleatorizar_preguntas: false,
  preguntas: [
    {
      enunciado: '',
      tipo: 'seleccion_multiple',
      opciones: [
        { texto: '', es_correcta: false },
        { texto: '', es_correcta: false },
        { texto: '', es_correcta: false },
        { texto: '', es_correcta: false }
      ],
      puntaje: 1
    }
  ]
})

const addQuestion = () => {
  form.preguntas.push({
    enunciado: '',
    tipo: 'seleccion_multiple',
    opciones: [
      { texto: '', es_correcta: false },
      { texto: '', es_correcta: false },
      { texto: '', es_correcta: false },
      { texto: '', es_correcta: false }
    ],
    puntaje: 1
  })
}

const removeQuestion = (index) => {
  if (form.preguntas.length > 1) {
    form.preguntas.splice(index, 1)
  }
}

const submit = () => {
  form.post(`/admin/cursos/${props.curso.id}/tests`, {
    preserveScroll: true,
    onSuccess: () => {
      router.visit(`/admin/cursos/${props.curso.id}/temas`)
    }
  })
}

const cancel = () => {
  router.visit(`/admin/cursos/${props.curso.id}/temas`)
}
</script>