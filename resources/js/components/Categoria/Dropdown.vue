<template>
    <div class="categoria-dropdown">
        <AutoComplete 
            v-model="selectedValue"
            dropdown 
            :suggestions="filteredItems" 
            @complete="search"
            placeholder="Escribe para buscar categoría..."
            optionLabel="nombre"
            forceSelection
            class="w-full"
        >
            <template #item="slotProps">
                <div class="flex items-center">
                    <span>{{ slotProps.item.nombre }}</span>
                </div>
            </template>
        </AutoComplete>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import AutoComplete from 'primevue/autocomplete';

const props = defineProps({
    modelValue: {
        type: [Number, String, Object],
        default: null
    },
    categorias: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['update:modelValue']);

const selectedValue = ref(null);
const filteredItems = ref([]);

// Sincronizar el valor inicial
watch(() => props.modelValue, (newValue) => {
    if (newValue && props.categorias) {
        const foundCategory = props.categorias.find(cat => cat.id === newValue);
        selectedValue.value = foundCategory || null;
    } else {
        selectedValue.value = null;
    }
}, { immediate: true });

// Emitir el cambio cuando se selecciona un item
watch(selectedValue, (newValue) => {
    if (newValue && newValue.id) {
        emit('update:modelValue', newValue.id);
    } else {
        emit('update:modelValue', null);
    }
});

const search = (event) => {
    if (!event.query.trim().length) {
        filteredItems.value = [...props.categorias];
    } else {
        filteredItems.value = props.categorias.filter((category) => {
            return category.nombre.toLowerCase().includes(event.query.toLowerCase());
        });
    }
};
</script>