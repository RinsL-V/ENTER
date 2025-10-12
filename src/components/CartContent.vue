<template>
  <div class="h-full flex flex-col">
    <!-- Список товаров -->
    <div class="flex-1 overflow-y-auto p-6">
      <div class="space-y-4">
        <!-- Товар в корзине -->
        <div class="border border-amber-50 rounded-lg p-4">
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <h3 class="text-lg font-semibold text-amber-50 mb-1">Глава 5.</h3>
              <p class="text-amber-100 text-sm leading-tight mb-2">
                Стратегия тайминга
              </p>
              <p class="text-amber-50 font-semibold">999 руб.</p>
            </div>
            <button class="text-amber-50 hover:text-amber-100 ml-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

<!-- Итого и оформление -->
    <div class="border-t border-amber-50 p-6">
      <!-- Итого -->
      <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
          <span class="text-amber-50 text-lg">Итого</span>
          <span class="text-amber-50 font-semibold text-xl">{{ totalPrice }} руб.</span>
        </div>
        
        <!-- Способ оплаты -->
        <div class="py-3 border-y border-amber-50 border-opacity-30">
          <!-- Заголовок с ссылкой -->
          <div class="flex justify-between items-center mb-3">
            <span class="text-white">Способ оплаты</span>
            <button 
              @click="goToPaymentMethods"
              class="text-amber-50 hover:text-amber-100 flex items-center gap-1 transition-colors text-sm"
            >
              Изменить <span>></span>
            </button>
          </div>
          
          <!-- Выбранная карта -->
          <div class="flex items-center gap-3 p-2 border-amber-50 bg-opacity-10 rounded-lg">
            <div class="w-4 h-4 border border-amber-50 rounded-full flex items-center justify-center bg-white">
              <div v-if="selectedPaymentMethod === 'card'" class="w-2 h-2 bg-black rounded-full"></div>
            </div>
            

            <!-- Номер карты -->
            <div class="flex-1">
              <p class="text-sm text-white">Мир ...1010</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Кнопка оформления -->
      <button class="w-full bg-amber-100 text-black font-semibold py-4 rounded-lg hover:bg-amber-50 transition-colors">
        Оформить заказ
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import CartItemList from './CartItemList.vue'

const emit = defineEmits(['open-payment-methods'])

// Данные корзины
const cartItems = [
  {
    id: 1,
    title: 'Глава 5.',
    description: 'Стратегия тайминга',
    price: 999
  }
]

const selectedPaymentMethod = ref('card') // По умолчанию выбрана карта

// Вычисляемые свойства
const totalPrice = computed(() => {
  return cartItems.reduce((sum, item) => sum + item.price, 0)
})

// Методы
const goToPaymentMethods = () => {
  // Закрываем корзину и открываем профиль в разделе оплаты
  emit('open-payment-methods')
}
</script>