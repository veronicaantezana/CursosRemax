<template>
  <div class="p-6">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold">Cursos de {{ categoryName }}</h1>
        <p class="text-gray-600">{{ cursos.length }} cursos disponibles</p>
      </div>

      <Link href="/" class="flex items-center gap-2 text-gray-600 hover:text-gray-900">
      ← Volver
      </Link>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <Card v-for="curso in cursos" :key="curso.id"
        class="cursor-pointer hover:shadow-lg transition-shadow duration-300">
        <template #header>
          <img :alt="curso.titulo" :src="curso.imagen" class="w-full h-48 object-cover" />
        </template>

        <template #title>{{ curso.titulo }}</template>
        <template #subtitle>{{ curso.instructor }}</template>

        <template #content>
          <p class="text-gray-600 line-clamp-2">{{ curso.descripcion }}</p>

          <div class="flex items-center justify-between mt-4">
            <div class="flex items-center gap-2">
            </div>

            <!-- <div class="text-lg font-bold text-green-600">
              {{ curso.precio }}
            </div>-->
          </div>
        </template>

        <template #footer>
          <div class="flex gap-3">
            <Link :href="`/cursos/${curso.id}`" class="flex-1">
            <Button label="Ver curso" severity="secondary" variant="outlined" class="w-full" />
            </Link>
            <Button icon="pi pi-heart" severity="secondary" variant="text" />
          </div>
        </template>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import Card from 'primevue/card'
import Button from 'primevue/button'


const page = usePage()
const categorySlug = computed(() => page.props.category || page.url.split('=')[1] || '')
const cursos = ref([
  {
    id: 1,
    titulo: 'Marketing Digital Avanzado',
    instructor: 'Ana Rodríguez',
    descripcion: 'Aprende estrategias avanzadas de marketing digital para potenciar tu negocio.',
    imagen: 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400',
    rating: 4.8,
    reseñas: 1247,
    //precio: '$89.99',
    duracion: '12 horas',
    nivel: 'Avanzado'
  },
  {
    id: 2,
    titulo: 'SEO para Principiantes',
    instructor: 'Carlos Méndez',
    descripcion: 'Domina los fundamentos del SEO y mejora el posicionamiento de tu web.',
    imagen: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
    rating: 4.6,
    reseñas: 893,
    //precio: '$59.99',
    duracion: '8 horas',
    nivel: 'Principiante'
  },
  {
    id: 3,
    titulo: 'Redes Sociales para Empresas',
    instructor: 'María González',
    descripcion: 'Estrategias efectivas para manejar redes sociales corporativas.',
    imagen: 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400',
    rating: 4.7,
    reseñas: 567,
    //precio: '$79.99',
    duracion: '10 horas',
    nivel: 'Intermedio'
  },
  {
    id: 4,
    titulo: 'Email Marketing Profesional',
    instructor: 'Roberto Silva',
    descripcion: 'Crea campañas de email marketing que convierten.',
    imagen: 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400',
    rating: 4.5,
    reseñas: 432,
    //precio: '$69.99',
    duracion: '6 horas',
    nivel: 'Intermedio'
  }
])

// Nombre de la categoría basado en el slug
const categoryName = computed(() => {
  const categories = {
    'marketing-comunicacion': 'Marketing y Comunicación',
    'habilidades-comerciales': 'Habilidades Comerciales',
    'legales-regulatorios': 'Aspectos Legales',
    'bienes-y-raices': 'Bienes y Raíces'
  }
  return categories[categorySlug.value] || 'Cursos'
})

const verCurso = (cursoId) => {
  router.get(`/cursos/${cursoId}`)
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>