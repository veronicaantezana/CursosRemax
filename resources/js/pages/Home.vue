<script setup>
import CategoryTabs from '@/components/Categoria/CategoryTabs.vue'
import { ref } from 'vue'

const categories = [
  { name: 'Marketing y Comunicación', slug: 'marketing-comunicacion' },
  { name: 'Habilidades Comerciales y de Negociación', slug: 'habilidades-comerciales' },
  { name: 'Aspectos Legales y Regulatorios', slug: 'legales-regulatorios' },
  { name: 'Introduccion a Bienes y Raices', slug: 'bienes-y-raices' },
  { name: 'Introduccion a Bienes y Raices medio', slug: 'bienes-y-raices-medio' }
]

const selected = ref(categories[0].slug)
</script>

<template>
  <AppLayout>
    <template #default>
      <div class="p-6">
        <CategoryTabs v-model="selected" :categories="categories" to="/" explore-href="/" />

        <div class="mt-6 text-sm text-gray-600">
          Categoría seleccionada: <b>{{ selected }}</b>
        </div>
      </div>
    </template>
  </AppLayout>
</template>
