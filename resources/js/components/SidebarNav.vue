<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  appTitle: { type: String, default: 'Remax Curse' },
  sections: {
    type: Array,
    default: () => ([
      {
        title: 'Discover',
        items: [
          { label: 'Inicio',        to: '/',            icon: 'home' },
          { label: 'Buscar',        to: '/buscar',      icon: 'search' },
          { label: 'Mi aprendizaje',to: '/aprendizaje', icon: 'broadcast' },
        ]
      },
      {
        title: 'Cursos',
        items: [
          { label: 'Guardados',     to: '/guardados',   icon: 'list' },
        ]
      }
    ])
  }
})

const page = usePage()
const isActive = (to) => computed(() => page.url === to)
const icons = {
  home: `
    <path d="M3 11l9-8 9 8v9a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-4H9v4a2 2 0 0 1-2 2H3z" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  `,
  search: `
    <circle cx="11" cy="11" r="7" stroke="currentColor" fill="none" />
    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" />
  `,
  broadcast: `
    <circle cx="6" cy="12" r="2" stroke="currentColor" fill="none" />
    <circle cx="12" cy="12" r="2" stroke="currentColor" fill="none" />
    <circle cx="18" cy="12" r="2" stroke="currentColor" fill="none" />
  `,
  list: `
    <line x1="8" y1="6" x2="21" y2="6" stroke="currentColor"/>
    <line x1="8" y1="12" x2="21" y2="12" stroke="currentColor"/>
    <line x1="8" y1="18" x2="21" y2="18" stroke="currentColor"/>
    <rect x="3" y="5" width="3" height="3" stroke="currentColor" fill="none"/>
    <rect x="3" y="11" width="3" height="3" stroke="currentColor" fill="none"/>
    <rect x="3" y="17" width="3" height="3" stroke="currentColor" fill="none"/>
  `
}
</script>

<template>
  <!-- Botón móvil -->
  <button 
    @click="toggle"
    class="md:hidden fixed top-4 left-4 z-50 w-10 h-10 bg-white border border-gray-200 rounded shadow"
  >
    ☰
  </button>

  <div 
    v-if="isOpen"
    @click="toggle"
    class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-40"/>

 <!-- Sidebar -->
  <aside 
    class="h-screen w-64 bg-white border-r border-gray-200 fixed md:static inset-y-0 left-0 z-40 transition-transform md:transform-none"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
  >
    <div class="px-4 py-4 flex justify-between items-center">
      <h1 class="text-sm font-semibold text-gray-900">{{ appTitle }}</h1>
      <button @click="toggle" class="lg:hidden">✕</button>
    </div>

    <nav class="px-2 space-y-6">
      <section v-for="(section, si) in sections" :key="si">
        <p class="px-2 text-xs font-medium text-gray-500 mb-2">{{ section.title }}</p>
        <ul class="space-y-1">
          <li v-for="(item, ii) in section.items" :key="ii">
            <Link
              :href="item.to"
              @click="isOpen = false"
              class="flex items-center gap-3 px-2 py-2 text-sm rounded-md transition"
              :class="isActive(item.to).value ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-50'"
            >
              <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke-width="1.6" v-html="icons[item.icon]"/>
              <span class="truncate">{{ item.label }}</span>
            </Link>
          </li>
        </ul>
      </section>
    </nav>
  </aside>
</template>