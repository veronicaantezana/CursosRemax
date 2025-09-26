<template>
  <div class="category-carousel-wrapper">
    <div class="category-carousel">
      <button v-if="showNavigation" @click="scrollLeft" class="carousel-nav carousel-nav-prev" :disabled="isAtStart">
        ←
      </button>

      <div class="carousel-container">
        <div ref="carouselRef" class="carousel-track"
          :style="{ transform: `translateX(-${currentIndex * itemWidth}px)` }">
          <button v-for="c in categories" :key="c.slug" @click="selectCategory(c.slug)" class="carousel-item"
            :class="{ 'carousel-item-active': active === c.slug }">
            {{ c.name }}
          </button>
        </div>
      </div>

      <button v-if="showNavigation" @click="scrollRight" class="carousel-nav carousel-nav-next" :disabled="isAtEnd">
        →
      </button>

      <Link :href="`${to}?category=${encodeURIComponent(active || '')}`" as="button" type="button" class="explore-btn">
      Explorar
      </Link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  categories: { type: Array, default: () => [] },
  modelValue: { type: String, default: '' },
  to: { type: String, default: '/buscar' },
  navigate: { type: Boolean, default: true },
  //visibleItems: { type: Number, default: 3 }
})

const emit = defineEmits(['update:modelValue', 'change'])

const active = ref(props.modelValue || props.categories[0]?.slug || '')
const currentIndex = ref(0)
const carouselRef = ref(null)
const itemWidth = ref(120)

// 1 item en móvil, 3 en desktop
const responsiveVisibleItems = computed(() => {
  return window.innerWidth < 768 ? 1 : 3
})

const showNavigation = computed(() => props.categories.length > responsiveVisibleItems.value)

const isAtStart = computed(() => currentIndex.value === 0)
const isAtEnd = computed(() =>
  currentIndex.value >= props.categories.length - responsiveVisibleItems.value
)

const selectCategory = (slug) => {
  active.value = slug
  emit('update:modelValue', slug)
  emit('change', slug)

  if (props.navigate) {
    router.visit(`/cursos?category=${encodeURIComponent(slug)}`, {
      preserveScroll: true,
      preserveState: true,
    })
  }
}

const scrollLeft = () => {
  if (currentIndex.value > 0) {
    currentIndex.value--
  }
}

const scrollRight = () => {
  if (currentIndex.value < props.categories.length - responsiveVisibleItems.value) {
    currentIndex.value++
  }
}

const updateItemWidth = () => {
  if (carouselRef.value && carouselRef.value.parentElement) {
    const containerWidth = carouselRef.value.parentElement.clientWidth;
    const visibleItems = window.innerWidth < 768 ? 1 : 3;
    itemWidth.value = containerWidth / visibleItems;
  }
}

onMounted(() => {
  updateItemWidth()
  window.addEventListener('resize', updateItemWidth)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateItemWidth)
})
</script>

<style scoped>
.category-carousel-wrapper {
  width: 100%;
  overflow: hidden;
}

.category-carousel {
  display: flex;
  align-items: center;
  gap: 12px;
  max-width: 800px;
  margin: 0 auto;
  width: 100%;
}

.carousel-container {
  flex: 1;
  overflow: hidden;
  position: relative;
  height: 40px;
  min-width: 0;
}

.carousel-track {
  display: flex;
  gap: 8px;
  transition: transform 0.3s ease;
  height: 100%;

}

.carousel-item {
  flex: 0 0 calc(33.333% - 6px);
  min-width: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 8px 12px;
  border-radius: 9999px;
  border: 1px solid #e5e7eb;
  background: white;
  color: #374151;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: center;
}

.carousel-item:hover {
  background: #f9fafb;
  border-color: #d1d5db;
  color: #111827;
}

.carousel-item-active {
  background: #111827;
  color: white;
  border-color: #111827;
}

.carousel-nav {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  border: 1px solid #d1d5db;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.carousel-nav:hover:not(:disabled) {
  background: #f3f4f6;
  border-color: #9ca3af;
}

.carousel-nav:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.explore-btn {
  flex-shrink: 0;
  padding: 8px 16px;
  border-radius: 9999px;
  background: #111827;
  color: white;
  font-size: 12px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: opacity 0.2s ease;
}

.explore-btn:hover {
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 767px) {
  .category-carousel-wrapper {
    max-width: 100vw;
    overflow: hidden;
  }

  .category-carousel {
    display: flex;
    gap: 8px;
    max-width: 300px;
    width: 90%;
  }

  .carousel-item {
    flex: 0 0 100% !important;
  }

}
</style>