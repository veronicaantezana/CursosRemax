<template>
  <div class="flex min-h-screen bg-gray-50">
    <SidebarNav />
     <main class="flex-1 min-h-screen transition-all duration-300">
      <div class="p-4 lg:p-6">
        <slot />
      </div>
    </main>
  </div>
</template>

<script setup>
import SidebarNav from '@/components/SidebarNav.vue'

defineOptions({
  inheritAttrs: false
})
</script>