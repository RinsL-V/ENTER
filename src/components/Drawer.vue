<template>
  <div>
    <!-- Overlay -->
    <div 
      v-if="isOpen"
     class="fixed top-0 left-0 h-full w-full bg-black z-10 opacity-70" 
      @click="closeDrawer"
    ></div>
    
    <!-- Drawer -->
    <div 
      class="fixed top-0 right-0 h-full w-96 bg-white z-50 transform transition-transform duration-300 ease-in-out"
      :class="isOpen ? 'translate-x-0' : 'translate-x-full'"
    >
      <div class="h-full flex flex-col">
        <!-- Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
          <h2 class="text-2xl font-bold text-gray-900">
            {{ title }}
          </h2>
          <button 
            @click="closeDrawer"
            class="text-gray-400 hover:text-gray-600 transition p-2 rounded-full hover:bg-gray-100"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-6">
          <component :is="currentContent" />
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, computed, watch } from 'vue'
import CartContent from './CartContent.vue'
import ProfileContent from './ProfileContent.vue'

const props = defineProps({
  type: {
    type: String,
    default: null,
    validator: (value) => ['cart', 'profile', null].includes(value)
  }
})

const emit = defineEmits(['close'])

const isOpen = computed(() => props.type !== null)

const contentComponents = {
  cart: CartContent,
  profile: ProfileContent
}

const currentContent = computed(() => {
  return props.type ? contentComponents[props.type] : null
})

const title = computed(() => {
  const titles = {
    cart: 'Корзина',
    profile: 'Профиль'
  }
  return props.type ? titles[props.type] : ''
})

const closeDrawer = () => {
  emit('close')
}

// Закрытие по ESC
const handleEscape = (event) => {
  if (event.key === 'Escape' && isOpen.value) {
    closeDrawer()
  }
}

watch(isOpen, (newVal) => {
  if (newVal) {
    document.addEventListener('keydown', handleEscape)
    document.body.style.overflow = 'hidden'
  } else {
    document.removeEventListener('keydown', handleEscape)
    document.body.style.overflow = 'auto'
  }
})
</script>