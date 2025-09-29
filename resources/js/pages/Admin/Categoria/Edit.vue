<template>
    <AdminLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                     <h1 class="text-2xl font-bold text-gray-900">Editar Categoría</h1>
                    <p class="text-gray-600">Modifica los datos de la categoría</p>
                </div>
                <Link href="/admin/categorias"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors flex items-center gap-2">
                    <i class="pi pi-arrow-left"></i>
                    Volver
                </Link>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header de la card -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-2">
                        <i class="pi pi-pencil text-blue-500"></i>
                        <span class="text-lg font-semibold text-gray-900">Editar Categoría</span>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-6">
                    <form @submit.prevent="submitForm" class="space-y-4 max-w-lg">
                        <div class="field">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Categoría *
                            </label>
                            <input 
                                id="nombre" 
                                v-model="form.nombre" 
                                type="text" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                :class="{ 'border-red-500': form.errors.nombre }"
                                placeholder="Ingresa el nombre de la categoría" 
                            />
                            <small class="text-red-500 text-sm mt-1 block" v-if="form.errors.nombre">
                                {{ form.errors.nombre }}
                            </small>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2 disabled:bg-blue-400 disabled:cursor-not-allowed font-medium"
                            >
                                <i class="pi pi-check" v-if="!form.processing"></i>
                                <i class="pi pi-spinner pi-spin" v-else></i>
                                {{ form.processing ? 'Actualizando...' : 'Actualizar' }}
                            </button>

                            <Link href="/admin/categorias" class="no-underline">
                                <button 
                                    type="button"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2 font-medium"
                                >
                                    <i class="pi pi-times"></i>
                                    Cancelar
                                </button>
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { onMounted } from 'vue'

const props = defineProps({
    categoria: {
        type: Object,
        required: true
    }
})

const form = useForm({
    nombre: props.categoria.nombre || ''
})

const submitForm = () => {
    form.post(`/admin/categorias/${props.categoria.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
        }
    })
}

// Focus en el input al cargar el componente
onMounted(() => {
    const nombreInput = document.getElementById('nombre')
    if (nombreInput) {
        nombreInput.focus()
    }
})
</script>