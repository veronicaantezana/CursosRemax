<template>
  
  <Card style="width: 25rem; overflow: hidden" class="curso-card">
    <template #header>
      <img :alt="curso.titulo" :src="curso.imagen" class="w-full h-48 object-cover" />
    </template>
    
    <template #title>{{ curso.titulo }}</template>
    <template #subtitle>{{ curso.instructor }}</template>
    
    <template #content>
      <p class="m-0 text-gray-600">
        {{ curso.descripcion }}
      </p>
    </template>
    
    <template #footer>
      <div class="flex gap-4 mt-1">
        <Button label="Ver detalles" severity="secondary" variant="outlined" class="w-full" />
        <Button label="Inscribirse" class="w-full" />
      </div>
    </template>
  </Card>
</template>

<script setup>
import Card from 'primevue/card'
import Button from 'primevue/button'

defineProps({
  curso: {
    type: Object,
    required: true
  }
})
</script>

<style scoped>
.curso-card {
  transition: transform 0.2s ease;
}

.curso-card:hover {
  transform: translateY(-4px);
}
</style>