<template>
    <div class="curso-detalle-page p-6">
        <div class="mb-6">
            <Breadcrumb :home="home" :model="breadcrumbItems" />
        </div>

        <!-- Header del curso -->
        <Card class="mb-6">
            <template #content>
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Imagen del curso -->
                    <div class="lg:w-1/3">
                        <img :src="curso.imagen" :alt="curso.titulo"
                            class="w-full h-64 lg:h-80 object-cover rounded-lg" />
                    </div>

                    <!-- Información del curso -->
                    <div class="lg:w-2/3">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ curso.titulo }}</h1>
                        <p class="text-lg text-gray-600 mb-4">{{ curso.descripcion }}</p>

                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="pi pi-clock text-blue-500"></i>
                                    <span class="font-semibold">{{ curso.duracion }}</span>
                                </div>
                                <span class="text-sm text-gray-500">Duración</span>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="pi pi-book text-green-500"></i>
                                    <span class="font-semibold">{{ curso.totalTemas }} temas</span>
                                </div>
                                <span class="text-sm text-gray-500">Contenido</span>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="pi pi-star text-yellow-500"></i>
                                    <span class="font-semibold">{{ curso.rating }}</span>
                                </div>
                                <span class="text-sm text-gray-500">Rating</span>
                            </div>

                            <div class="text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="pi pi-user text-purple-500"></i>
                                    <span class="font-semibold">{{ curso.nivel }}</span>
                                </div>
                                <span class="text-sm text-gray-500">Nivel</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <Button label="Inscribirse en el curso" icon="pi pi-check" class="p-button-primary flex-1"
                                size="large" />
                            <Button severity="secondary" outlined class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4">
                                    <path
                                        d="M192 64C156.7 64 128 92.7 128 128L128 544C128 555.5 134.2 566.2 144.2 571.8C154.2 577.4 166.5 577.3 176.4 571.4L320 485.3L463.5 571.4C473.4 577.3 485.7 577.5 495.7 571.8C505.7 566.1 512 555.5 512 544L512 128C512 92.7 483.3 64 448 64L192 64z" />
                                </svg>
                                Guardar
                            </Button>
                        </div>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Contenido del curso -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar de temas -->
            <Card class="lg:col-span-1">
                <template #title>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-list"></i>
                        <span>Contenido del Curso</span>
                    </div>
                </template>
                <template #content>
                    <div class="space-y-2">
                        <div v-for="(tema, index) in temas" :key="tema.id"
                            class="p-3 border-round cursor-pointer transition-all duration-200" :class="[
                                temaActivo === index
                                    ? 'bg-blue-50 border-left-3 border-blue-500'
                                    : 'border-left-3 border-transparent hover:bg-gray-50'
                            ]" @click="cambiarTema(index)">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <span class="text-sm font-medium text-blue-600 block">
                                        Tema {{ index + 1 }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 block mt-1 line-clamp-2">
                                        {{ tema.titulo }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500 whitespace-nowrap ml-2">
                                    {{ tema.duracion }}
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Contenido del tema activo -->
            <div class="lg:col-span-3">
                <Card v-if="temaActivo !== null">
                    <template #title>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h2 class="text-2xl font-bold m-0">{{ temas[temaActivo].titulo }}</h2>
                                <div class="flex items-center text-sm text-gray-500 mt-2">
                                    <span class="mr-4">Duración: {{ temas[temaActivo].duracion }}</span>
                                    <span>Tema {{ temaActivo + 1 }} de {{ temas.length }}</span>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <Button icon="pi pi-chevron-left" severity="secondary" outlined
                                    :disabled="temaActivo === 0" @click="cambiarTema(temaActivo - 1)" />
                                <Button icon="pi pi-chevron-right" severity="secondary" outlined
                                    :disabled="temaActivo === temas.length - 1" @click="cambiarTema(temaActivo + 1)" />
                            </div>
                        </div>
                    </template>

                    <template #content>
                        <!-- Video player -->
                        <div class="mb-6">
                            <div class="bg-gray-900 rounded-lg aspect-video flex items-center justify-center">
                                <div class="text-white text-center">
                                    <i class="pi pi-play-circle text-6xl mb-3 opacity-50"></i>
                                    <p class="text-xl font-semibold">Reproductor de video</p>
                                    <p class="text-gray-300">{{ temas[temaActivo].titulo }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold mb-3">Descripción del tema</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ temas[temaActivo].descripcion }}
                            </p>
                        </div>

                        <!-- Recursos -->
                        <div v-if="temas[temaActivo].recursos && temas[temaActivo].recursos.length" class="mb-6">
                            <h3 class="text-xl font-semibold mb-3">Recursos adicionales</h3>
                            <div class="grid gap-3">
                                <a v-for="recurso in temas[temaActivo].recursos" :key="recurso.id" :href="recurso.url"
                                    target="_blank"
                                    class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="pi pi-download text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <span class="font-medium block text-blue-600">{{ recurso.nombre }}</span>
                                        <span class="text-sm text-gray-500">{{ recurso.tipo }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Navegación entre temas -->
                        <div class="flex justify-between pt-4 border-t">
                            <Button v-if="temaActivo > 0" label="Tema anterior" icon="pi pi-chevron-left"
                                severity="secondary" outlined @click="cambiarTema(temaActivo - 1)" />
                            <div v-else></div>

                            <Button v-if="temaActivo < temas.length - 1" label="Siguiente tema"
                                icon="pi pi-chevron-right" iconPos="right" class="p-button-primary"
                                @click="cambiarTema(temaActivo + 1)" />
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Card from 'primevue/card'
import Button from 'primevue/button'
import Breadcrumb from 'primevue/breadcrumb'

const props = defineProps({
    curso: {
        type: Object,
        required: true
    },
    temas: {
        type: Array,
        default: () => []
    }
})


const home = ref({
    icon: 'pi pi-home',
    route: '/'
})

const breadcrumbItems = ref([
    { label: 'Cursos', route: '/cursos' },
    { label: props.curso.titulo }
])

// Estado reactivo
const temaActivo = ref(0)

// Métodos
const cambiarTema = (index) => {
    if (index >= 0 && index < props.temas.length) {
        temaActivo.value = index
    }
}

// Computed
const curso = computed(() => props.curso)
const temas = computed(() => props.temas)
</script>

<style scoped>
.curso-detalle-page {
    max-width: 1400px;
    margin: 0 auto;
}

.border-left-3 {
    border-left-width: 3px;
}

.aspect-video {
    aspect-ratio: 16 / 9;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>