<template>
    <button 
        type="submit"
        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="loading"
    >
        <i v-if="loading" class="pi pi-spinner pi-spin mr-2"></i>
        <slot />
    </button>
</template>

<script setup>
defineProps({
    loading: {
        type: Boolean,
        default: false
    }
});
</script>