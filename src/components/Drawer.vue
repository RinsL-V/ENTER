<template>
  <div v-if="isVisible" class="fixed inset-0 z-50">
    <!-- Overlay с размытием -->
    <div class="absolute inset-0 drawer-overlay" @click="$emit('close')"></div>
    
    <!-- Drawer content -->
    <div class="absolute right-0 top-0 h-full w-96 bg-black border-l border-amber-50 shadow-xl">
      <div class="h-full flex flex-col">
        <!-- Заголовок -->
        <div class="p-6 border-b border-amber-50">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-mono text-amber-50">Корзина</h2>
            <button @click="$emit('close')" class="text-amber-50 hover:text-amber-100">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Контент в зависимости от типа -->
        <div v-if="type === 'cart'" class="flex-1 overflow-hidden">
          <CartContent @open-payment-methods="handleOpenPaymentMethods" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import CartContent from './CartContent.vue'

const props = defineProps({
  type: String
})

const emit = defineEmits(['close', 'open-payment-methods'])

const isVisible = computed(() => {
  return props.type !== null
})

const handleOpenPaymentMethods = () => {
  // Закрываем корзину и открываем профиль
  emit('close')
  emit('open-payment-methods')
}
</script>

<style scoped>
.drawer-overlay {
  background: rgba(0, 0, 0, 0.5);
  backdrop-filter: blur(4px);
}
</style>