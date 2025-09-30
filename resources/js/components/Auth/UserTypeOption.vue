<template>
    <div class="flex-1">
        <div 
            class="border-2 rounded-lg p-4 text-center cursor-pointer transition-all duration-200"
            :class="selected 
                ? 'border-blue-500 bg-blue-50' 
                : 'border-gray-200 bg-gray-50 hover:border-gray-300'"
            @click="$emit('select')"
        >
            <i :class="`pi ${option.icon} text-2xl block mb-2`" 
                class="selected ? 'text-blue-500' : 'text-gray-600'"></i>
            <span class="font-medium" 
                  :class="selected ? 'text-blue-500' : 'text-gray-600'">
                {{ option.label }}
            </span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    option: {
        type: Object,
        required: true
    },
    selected: {
        type: Boolean,
        default: false
    }
});

defineEmits(['select']);
</script>