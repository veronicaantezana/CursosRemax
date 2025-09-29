<template>
    <AdminLayout title="Editar Categoría" subtitle="Modifica los datos de la categoría">
        <div class="space-y-6">
            <!-- ... mismo header ... -->

            <Card class="bg-white border border-gray-200 shadow-sm">
                <template #content>
                    <form @submit.prevent="submitForm" class="space-y-4 max-w-lg">
                        <div class="field">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Categoría *
                            </label>
                            <InputText 
                                id="nombre" 
                                v-model="form.nombre" 
                                type="text" 
                                class="w-full"
                                :class="{ 'border-red-500': form.errors.nombre }"
                                placeholder="Ingresa el nombre de la categoría" 
                                unstyled
                            />
                            <small class="text-red-500 text-sm mt-1 block" v-if="form.errors.nombre">
                                {{ form.errors.nombre }}
                            </small>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2 disabled:bg-blue-400 font-medium"
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
                </template>
            </Card>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import Card from 'primevue/card'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'

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