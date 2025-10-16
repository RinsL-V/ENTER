<template>
  <div class="h-full flex flex-col relative overflow-hidden">
    <div class="noise-overlay-section"></div>
    
    <!-- Список товаров -->
    <div class="flex-1 overflow-y-auto p-6 relative z-10">
      <div class="space-y-4">
        <!-- Товар в корзине -->
        <div 
          v-for="item in cartItems" 
          :key="item.id"
          class="border border-gray-500/50 rounded-lg p-4 bg-black/20 backdrop-blur-lg shadow-2xl relative overflow-hidden"
        >
          <div class="noise-overlay-card-strong"></div>
          <div class="flex justify-between items-start relative z-10">
            <div class="flex-1">
              <h3 class="text-lg font-regular text-gray-100 mb-1">{{ item.title }}</h3>
              <p class="text-gray-100 font-semibold">{{ item.price }} руб.</p>
            </div>
            <button 
              @click="removeFromCart(item.id)"
              class="text-gray-300 hover:text-gray-100 ml-2 transition-colors duration-300 relative z-10"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Пустая корзина -->
      <div v-if="cartItems.length === 0" class="text-center py-8">
        <p class="text-gray-400">Корзина пуста</p>
      </div>
    </div>

    <!-- Итого и оформление -->
    <div v-if="cartItems.length > 0" class="border-t border-gray-500/50 p-6 relative z-10">
      <div class="noise-overlay-section"></div>
      
      <!-- Итого -->
      <div class="mb-6 relative z-10">
        <div class="flex justify-between items-center mb-4">
          <span class="text-gray-100 text-lg">Итого</span>
          <span class="text-gray-100 font-semibold text-xl">{{ totalPrice }} руб.</span>
        </div>
        
        <!-- Способ оплаты -->
        <div class="py-3 border-y border-gray-500/50">
          <!-- Заголовок с ссылкой -->
          <div class="flex justify-between items-center mb-3">
            <span class="text-gray-100">Способ оплаты</span>
            <button 
              @click="goToPaymentMethods"
              class="text-gray-300 hover:text-gray-100 flex items-center gap-1 transition-colors duration-300 text-sm"
            >
              Изменить <span>></span>
            </button>
          </div>
          
          <div class="flex items-center gap-3 p-2 border border-gray-500/50 rounded-lg bg-black/20 backdrop-blur-sm">
            <div class="w-4 h-4 border border-gray-300 rounded-full flex items-center justify-center bg-white">
              <div v-if="selectedPaymentMethod === 'card'" class="w-2 h-2 bg-black rounded-full"></div>
            </div>
            
            <!-- Номер карты -->
            <div class="flex-1">
              <p class="text-sm text-gray-100">Мир ...1010</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Кнопка оформления -->
      <button 
        @click="createOrder"
        :disabled="loading"
        class="w-full bg-white text-black font-semibold py-3 rounded-lg hover:bg-gray-200 transition-all duration-300 relative z-10 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="loading">Оформление...</span>
        <span v-else>Оформить заказ</span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const emit = defineEmits(['open-payment-methods', 'order-created'])

const loading = ref(false)
const selectedPaymentMethod = ref('card')
const cartItems = ref([])

// Базовый URL API
const API_BASE_URL = 'http://localhost:8000/api'

// Загрузка корзины из localStorage
const loadCart = () => {
  const saved = localStorage.getItem('cart')
  if (saved) {
    cartItems.value = JSON.parse(saved)
  }
}

// Сохранение корзины в localStorage
const saveCart = () => {
  localStorage.setItem('cart', JSON.stringify(cartItems.value))
}

// Вычисляемые свойства
const totalPrice = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + item.price, 0)
})

// Методы
const goToPaymentMethods = () => {
  emit('open-payment-methods')
}

const removeFromCart = (chapterId) => {
  const index = cartItems.value.findIndex(item => item.id === chapterId)
  if (index !== -1) {
    cartItems.value.splice(index, 1)
    saveCart()
  }
}

const clearCart = () => {
  cartItems.value = []
  localStorage.removeItem('cart')
}

const createOrder = async () => {
  try {
    loading.value = true
    
    const items = cartItems.value.map(item => ({
      chapter_id: item.id,
      quantity: 1
    }))

    const token = localStorage.getItem('auth_token')
    
    if (!token) {
      alert('Пожалуйста, войдите в систему')
      return
    }

    const response = await fetch(`${API_BASE_URL}/orders`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({ items })
    })

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}))
      throw new Error(errorData.message || `HTTP error! status: ${response.status}`)
    }

    const data = await response.json()
    
    // Очищаем корзину после успешного заказа
    clearCart()
    emit('order-created', data.order)
    alert('Заказ успешно создан и отправлен на модерацию!')
    
  } catch (error) {
    console.error('Error creating order:', error)
    alert(`Ошибка при оформлении заказа: ${error.message}`)
  } finally {
    loading.value = false
  }
}

// Загружаем корзину при монтировании
onMounted(() => {
  loadCart()
})
</script>