<template>
    <AuthLayout>
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <i class="pi pi-user text-6xl text-blue-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Bienvenido</h1>
            <p class="text-gray-600 font-medium">Inicia sesión en tu cuenta</p>
        </div>
        <div v-if="authStore.loading" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center justify-center space-x-3">
                <i class="pi pi-spinner pi-spin text-blue-500 text-xl"></i>
                <span class="text-blue-700 font-medium">Verificando credenciales, por favor espere...</span>
            </div>
        </div>

       
        <div v-if="authStore.error" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center space-x-3">
                <i class="pi pi-exclamation-triangle text-red-500 text-xl"></i>
                <span class="text-red-700 font-medium">Credenciales incorrectas</span>
            </div>
        </div>

        <LoginForm @submit="handleSubmit" :loading="authStore.loading" :errors="errors" />

        <div class="text-center mt-6">
            <span class="text-gray-600 text-sm">Sistema Cursos remax</span>
        </div>
    </AuthLayout>
</template>

<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import LoginForm from '@/Components/Auth/LoginForm.vue';
import { useAuthStore } from '@/stores/authStore';
import { ref } from 'vue';

import { router } from '@inertiajs/vue3';

const authStore = useAuthStore();
const errors = ref({});

const handleSubmit = async (formData) => {
    console.log(' Iniciando proceso de login...');
    if (!validateForm(formData)) return;

    const credentials = {
        username: formData.username,
        password: formData.password
    };
    //console.log(' Enviando a authStore:', credentials);
    await authStore.login(credentials);
};

const validateForm = (formData) => {
    errors.value = {};

    if (!formData.username.trim()) {
        errors.value.username = 'El usuario es requerido.';
    }

    if (!formData.password) {
        errors.value.password = 'La contraseña es requerida.';
    }

    return Object.keys(errors.value).length === 0;
};
</script>