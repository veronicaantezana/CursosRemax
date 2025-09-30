<template>
    <div class="space-y-2">
        <label :for="id" class="block text-gray-900 font-semibold">{{ label }}</label>
        <div class="relative">
            <i :class="[
                `pi ${icon} absolute left-3 top-1/2 transform -translate-y-1/2`,
                disabled ? 'text-gray-300' : 'text-gray-400'
            ]"></i>
            <input :id="id" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
                :placeholder="placeholder"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors disabled:bg-gray-100 disabled:cursor-not-allowed"
                :class="{ 'border-red-500': error }" :disabled="disabled" />
        </div>
        <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    label: {
        type: String,
        required: true
    },
    icon: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    placeholder: {
        type: String,
        default: ''
    },
    error: {
        type: String,
        default: ''
    },
    disabled: {
        type: Boolean,
        default: false
    },
    id: {
        type: String,
        default: () => `input-${Math.random().toString(36).substr(2, 9)}`
    }
});

defineEmits(['update:modelValue']);
</script>