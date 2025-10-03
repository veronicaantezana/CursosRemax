<template>
  <AdminLayout :title="`Crear Tema - ${curso.nombre}`" subtitle="Agrega un nuevo tema al curso">
    <div class="space-y-6">
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Crear Tema</h1>
          <p class="text-gray-600">Agrega un nuevo tema al curso: {{ curso.nombre }}</p>
        </div>
        <Link :href="`/admin/cursos`" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
          <i class="pi pi-arrow-left"></i>
          Volver al curso
        </Link>
      </div>

      <div v-if="flashSuccess" class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ flashSuccess }}
      </div>

      <div v-if="flashError" class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ flashError }}
      </div>

      <Card class="shadow-lg border border-gray-200">
        <template #content>
          <form @submit.prevent="submit" class="space-y-6 p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
              <h3 class="font-semibold text-blue-900 mb-2">Curso: {{ curso.nombre }}</h3>
              <p class="text-sm text-blue-700">{{ curso.descripcion }}</p>
            </div>
            
            <div class="space-y-2">
              <label for="nombre" class="block text-sm font-medium text-gray-700">
                Nombre del Tema *
              </label>
              <InputText
                id="nombre"
                v-model="form.nombre"
                type="text"
                class="w-full custom-input"
                :class="form.errors.nombre ? 'border-red-500' : ''"
                placeholder="Ej: Introducción al Marketing Digital"
              />
              <p v-if="form.errors.nombre" class="text-red-600 text-sm mt-1">
                {{ form.errors.nombre }}
              </p>
            </div>

            <div class="space-y-2">
              <label for="duracion" class="block text-sm font-medium text-gray-700">
                Duración (minutos) *
              </label>
              <InputNumber
                id="duracion"
                v-model="form.duracion"
                class="w-full custom-inputnumber"
                :class="form.errors.duracion ? 'border-red-500' : ''"
                placeholder="60"
                :min="1"
                :max="480"
              />
              <p v-if="form.errors.duracion" class="text-red-600 text-sm mt-1">
                {{ form.errors.duracion }}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                Duración estimada del tema en minutos (1-480 minutos)
              </p>
            </div>

            <div class="space-y-4">
              <label class="block text-sm font-medium text-gray-700">
                Material del Tema (Opcional)
              </label>
              <p class="text-xs text-gray-500 mb-4">
                Puedes subir un archivo, agregar una URL, o ambos
              </p>
              
              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Subir Archivo</label>
                <input
                  type="file"
                  ref="archivoInput"
                  @change="handleFileUpload"
                  class="w-full border border-gray-300 rounded-lg p-2"
                  accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov"
                />
                <p class="text-xs text-gray-500">
                  Formatos: PDF, Word, PowerPoint, Excel, Imágenes, Video (max 50MB)
                </p>
                
                <div v-if="form.archivo" class="bg-green-50 border border-green-200 rounded-lg p-3 mt-2">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <i class="pi pi-file text-green-600 text-lg"></i>
                      <div>
                        <p class="text-sm font-medium text-green-800">{{ form.archivo.name }}</p>
                        <p class="text-xs text-green-600">
                          {{ (form.archivo.size / 1024 / 1024).toFixed(2) }} MB
                        </p>
                      </div>
                    </div>
                    <Button 
                      @click="eliminarArchivo"
                      severity="danger" 
                      text
                      class="p-1 hover:bg-red-100"
                    >
                      <i class="pi pi-times"></i>
                    </Button>
                  </div>
                </div>
              </div>

              <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">URL de Recurso</label>
                <InputText
                  v-model="form.url"
                  class="w-full custom-input"
                  :class="form.errors.url ? 'border-red-500' : ''"
                  placeholder="https://youtube.com/watch?v=... o https://drive.google.com/..."
                />
                <p v-if="form.errors.url" class="text-red-600 text-sm mt-1">
                  {{ form.errors.url }}
                </p>
                <p class="text-xs text-gray-500">
                  YouTube, Vimeo, Google Drive, enlaces externos, etc.
                </p>
                
                
                <div v-if="form.url" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-2">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                      <i class="pi pi-link text-blue-600 text-lg"></i>
                      <div>
                        <p class="text-sm font-medium text-blue-800">URL agregada</p>
                        <p class="text-xs text-blue-600 truncate max-w-xs">{{ form.url }}</p>
                      </div>
                    </div>
                    <Button 
                      @click="eliminarUrl"
                      severity="danger" 
                      text
                      class="p-1 hover:bg-red-100"
                    >
                      <i class="pi pi-times"></i>
                    </Button>
                  </div>
                </div>
              </div>

              <div v-if="!form.archivo && !form.url" class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                <i class="pi pi-info-circle text-gray-400 text-lg mb-2"></i>
                <p class="text-sm text-gray-500">Puedes agregar material más tarde si lo deseas</p>
              </div>
            </div>

            <div class="flex gap-3 pt-4">
              <Link 
                :href="`/admin/cursos`"
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
                {{ form.processing ? 'Creando...' : 'Crear Tema' }}
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
import { computed, ref } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'

const page = usePage()

const flashSuccess = computed(() => page.props.flash?.success)
const flashError = computed(() => page.props.flash?.error)

const props = defineProps({
  curso: {
    type: Object,
    required: true
  }
})

const archivoInput = ref(null)
const form = useForm({
  curso_id: props.curso.id,
  nombre: '',
  duracion: null,
  archivo: null,
  url: ''
})

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {

    if (file.size > 50 * 1024 * 1024) {
      alert('El archivo es demasiado grande. Máximo 50MB permitidos.')
      event.target.value = ''
      return
    }
    form.archivo = file
  }
}

const eliminarArchivo = () => {
  form.archivo = null
  if (archivoInput.value) {
    archivoInput.value.value = ''
  }
}

const eliminarUrl = () => {
  form.url = ''
}

const submit = () => {
  
  if (!form.nombre) {
    alert('El nombre del tema es obligatorio')
    return
  }

  if (!form.duracion || form.duracion < 1) {
    alert('La duración debe ser de al menos 1 minuto')
    return
  }

  
  const formData = new FormData()
  formData.append('curso_id', form.curso_id)
  formData.append('nombre', form.nombre)
  formData.append('duracion', form.duracion)
  
  
  if (form.archivo) {
    formData.append('archivo', form.archivo)
  }
  
 
  if (form.url) {
    formData.append('url', form.url)
  }


  form.post('/admin/temas', {
    data: formData,
    preserveScroll: true,
    onSuccess: () => {
       window.location.href = `/admin/cursos/${props.curso.id}/temas`
    },
    onError: (errors) => {
      console.log('Errores:', errors)
    }
  })
}
</script>

<style scoped>
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
</style>