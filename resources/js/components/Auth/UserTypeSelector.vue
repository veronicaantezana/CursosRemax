<template>
    <div class="space-y-3">
        <label class="block text-gray-900 font-semibold">Tipo de Usuario</label>
        <div class="flex gap-4">
            <UserTypeOption 
                v-for="option in userTypes"
                :key="option.value"
                :option="option"
                :selected="modelValue === option.value"
                @select="$emit('update:modelValue', option.value)"
            />
        </div>
        <p v-if="error" class="text-red-500 text-sm">{{ error }}</p>
    </div>
</template>

<script setup>
import UserTypeOption from './UserTypeOption.vue';

defineProps({
    modelValue: {
        type: String,
        required: true
    },
    error: {
        type: String,
        default: ''
    }
});

defineEmits(['update:modelValue']);

const userTypes = [
    { value: 'agente', label: 'Agente', icon: 'pi-user' },
    { value: 'admin', label: 'Administrador', icon: 'pi-shield' }
];
</script>