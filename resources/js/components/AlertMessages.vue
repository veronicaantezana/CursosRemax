<template>
  <div v-if="success" class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
    {{ success }}
  </div>
  <div v-if="error" class="p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
    {{ error }}
  </div>
</template>

<script setup>
defineProps({
  success: String,
  error: String
})
</script>