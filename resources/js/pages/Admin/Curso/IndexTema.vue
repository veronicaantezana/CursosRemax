<template>
    <AdminLayout :title="`Temas - ${curso.nombre}`" subtitle="Gestiona los temas del curso">
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Temas: {{ curso.nombre }}</h1>
                    <p class="text-gray-600">{{ temas.length }} temas registrados</p>
                </div>
                <div class="flex gap-2">
                    <Link :href="`/admin/cursos/${curso.id}/temas/crear`"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                    <i class="pi pi-plus"></i>
                    Nuevo Tema
                    </Link>
                    <Link href="/admin/cursos" class="text-gray-600 hover:text-gray-900 flex items-center gap-2">
                    <i class="pi pi-arrow-left"></i>
                    Volver a cursos
                    </Link>
                </div>
            </div>

            <!-- Información del curso -->
            <Card class="shadow-lg border border-gray-200">
                <template #content>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Categoría:</span>
                                <p class="text-gray-900">{{ curso.categoria?.nombre || 'Sin categoría' }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Duración:</span>
                                <p class="text-gray-900">{{ curso.tiempoVigencia }} días</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Temas:</span>
                                <p class="text-gray-900">{{ temas.length }}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Calificación:</span>
                                <p class="text-gray-900">{{ curso.calificacion || 'No calificado' }}/100</p>
                            </div>
                        </div>
                       

                    </div>

                </template>
            </Card>

            <!-- Lista de temas -->
            <Card>
                <template #content>
                    <div v-if="temas.length === 0" class="text-center py-12">
                        <i class="pi pi-book text-5xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">No hay temas registrados</p>
                        <p class="text-gray-400 text-sm mt-1">Comienza agregando el primer tema para este curso</p>
                        <Link :href="`/admin/cursos/${curso.id}/temas/crear`"
                            class="mt-6 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors inline-flex items-center gap-2">
                        <i class="pi pi-plus"></i>
                        Crear primer tema
                        </Link>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="tema in temas" :key="tema.id"
                            class="border border-gray-200 rounded-lg hover:border-gray-300 transition-colors">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ tema.nombre }}</h3>
                                        <p class="text-gray-600 mt-1">Duración: {{ tema.duracion }} minutos</p>

    
                                        <div v-if="tema.archivo_path || tema.url" class="mt-4">
                                            <p class="text-sm font-medium text-gray-700 mb-3">Materiales:</p>
                                            <div class="space-y-2">
                                                <!-- Mostrar archivo si existe -->
                                                <div v-if="tema.archivo_path"
                                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                                    <div class="flex items-center gap-3">
                                                        <i :class="[tema.icono, tema.color, 'text-xl']"></i>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">{{
                                                                tema.nombre_archivo }}</p>
                                                            <p class="text-xs text-gray-500 capitalize">{{
                                                                tema.tipo_archivo }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1">
                                                        <Button @click="verArchivo(tema)"
                                                            class="p-button-text p-button-sm text-blue-600"
                                                            :title="`Ver ${tema.nombre_archivo}`">
                                                        
                                                        <i class="pi pi-eye"></i>
                                                        </Button>
                                                        
                                                    </div>
                                                </div>

                                                <!-- Mostrar URL si existe -->
                                                <div v-if="tema.url"
                                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                                    <div class="flex items-center gap-3">
                                                        <i class="pi pi-link text-blue-600 text-xl"></i>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">URL de video
                                                            </p>
                                                            <p class="text-xs text-gray-500 truncate max-w-xs">{{
                                                                tema.url }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-1">
                                                        <Button @click="abrirUrl(tema.url)"
                                                            class="p-button-text p-button-sm text-blue-600"
                                                            title="Abrir URL">
                                                            <i class="pi pi-external-link"></i>
                                                        </Button>
                                                        <Button @click="eliminarUrl(tema)" severity="danger" text
                                                            class="p-1 hover:bg-red-100" title="Eliminar URL">
                                                            <i class="pi pi-trash text-xs"></i>
                                                        </Button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div v-else class="mt-4">
                                            <p class="text-sm text-gray-400 italic">No hay materiales agregados</p>
                                        </div>
                                    </div>

                                    <div class="flex gap-2 ml-6">

                                        <Link :href="`/admin/cursos/${curso.id}/temas/${tema.id}/editar`"
                                            class="p-button p-button-text p-button-sm text-blue-600 border border-blue-200 flex items-center gap-1"
                                            title="Editar tema y materiales">
                                        <i class="pi pi-pencil"></i>
                                        Editar
                                        </Link>


                                        <Button @click="eliminarTema(tema)"
                                            class="p-button-text p-button-sm text-red-600" title="Eliminar tema">
                                            <i class="pi pi-trash"></i>
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <ConfirmDialog>
            <template #container="{ message, acceptCallback, rejectCallback }">
                <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                        <div class="flex items-center gap-3 p-6 border-b border-gray-200">
                            <div class="bg-red-100 p-2 rounded-full">
                                <i class="pi pi-exclamation-triangle text-red-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Confirmar eliminación</h3>
                                <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                            </div>
                        </div>

                        <div class="p-6">
                            <p class="text-gray-700">{{ message.message }}</p>
                        </div>

                        <div class="flex gap-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                            <button @click="rejectCallback"
                                class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors font-medium">
                                Cancelar
                            </button>
                            <button @click="acceptCallback"
                                class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                Sí, eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </ConfirmDialog>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import { useConfirm } from "primevue/useconfirm"
import ConfirmDialog from 'primevue/confirmdialog'

const confirm = useConfirm()

const props = defineProps({
    curso: {
        type: Object,
        required: true
    },
    temas: {
        type: Array,
        required: true
    }
})

const descargarArchivo = (tema) => {
    if (tema.archivo_path) {
        window.open(`/storage/${tema.archivo_path}`, '_blank')
    }
}

const abrirUrl = (url) => {
    if (url) {
        window.open(url, '_blank')
    }
}

const eliminarArchivo = (tema) => {
    confirm.require({
        message: `¿Estás seguro de eliminar el archivo "${tema.nombre_archivo}"?`,
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sí, eliminar',
        rejectLabel: 'Cancelar',
        accept: () => {
            router.put(`/admin/cursos/${props.curso.id}/temas/${tema.id}`, {
                archivo_path: null,
                tipo_archivo: tema.url ? 'video' : null
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    window.location.reload()
                }
            })
        }
    })
}
const verArchivo = (tema) => {
  if (tema.archivo_path) {
    // Abrir en nueva pestaña para visualización
    window.open(`/storage/${tema.archivo_path}`, '_blank')
  }
}

const eliminarUrl = (tema) => {
    confirm.require({
        message: `¿Estás seguro de eliminar la URL del tema?`,
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sí, eliminar',
        rejectLabel: 'Cancelar',
        accept: () => {
            router.put(`/admin/cursos/${props.curso.id}/temas/${tema.id}`, {
                url: null,
                tipo_archivo: tema.archivo_path ? tema.tipo_archivo : null
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    window.location.reload()
                }
            })
        }
    })
}

const eliminarTema = (tema) => {
    confirm.require({
        message: `¿Estás seguro de eliminar el tema "${tema.nombre}"?`,
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sí, eliminar',
        rejectLabel: 'Cancelar',
        accept: () => {
            router.delete(`/admin/cursos/${props.curso.id}/temas/${tema.id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    window.location.reload()
                }
            })
        }
    })
}
</script>