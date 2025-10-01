<template>
    <form @submit.prevent="$emit('submit', form)" class="space-y-6">
        

        <FormInput
            v-model="form.username"
            label="Usuario"
            icon="pi-user"
            type="text"
            placeholder="Ingresa tu usuario"
            :error="errors.username"
            :disabled="loading"
        />

        <FormInput
            v-model="form.password"
            label="Contraseña"
            icon="pi-lock"
            type="password"
            placeholder="Ingresa tu contraseña"
            :error="errors.password"
            :disabled="loading"
        />

        <SubmitButton :loading="loading">
            {{ loading ? 'Verificando...' : 'Iniciar Sesión' }}
        </SubmitButton>
    </form>
</template>

<script setup>
import UserTypeSelector from './UserTypeSelector.vue';
import FormInput from '../UI/FormInput.vue';
import SubmitButton from '../UI/SubmitButton.vue';
import { reactive, watch } from 'vue';

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

defineEmits(['submit']);

const form = reactive({
    userType: 'agente',
    username: '',
    password: ''
});


defineExpose({ form });
</script>