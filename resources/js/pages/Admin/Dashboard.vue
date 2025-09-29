<template>
  <AdminLayout title="Dashboard" subtitle="Panel de administración">
    <div class="space-y-6">
      <h1 class="text-2xl font-bold">Bienvenido al Panel de Administración</h1>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <Card>
          <template #title>Gestión de Categorías</template>
          <template #content>
            <p class="mb-4">Administra las categorías de cursos</p>
            <Link 
              href="/admin/categorias" 
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
            >
              Ver Categorías
            </Link>
          </template>
        </Card>

        <Card>
          <template #title>Crear Nueva Categoría</template>
          <template #content>
            <p class="mb-4">Añade una nueva categoría al sistema</p>
            <Link 
              href="/admin/categorias/crear" 
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            >
              Crear Categoría
            </Link>
          </template>
        </Card>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link } from '@inertiajs/vue3'
import Card from 'primevue/card'
</script>