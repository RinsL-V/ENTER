<template>
  <div class="max-w-6xl mx-auto">
    <!-- Основной контент в две колонки -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Левая колонка - Актуальные заказы -->
      <div class="lg:col-span-2">
        <h2 class="text-2xl font-mono text-gray-100 mb-6">Текущие заказы</h2>
        
        <!-- Список заказов -->
        <div class="space-y-4">
          <div 
            v-for="order in pendingOrders" 
            :key="order.id"
            class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl"
          >
            <div class="flex justify-between items-start mb-3">
              <div>
                <h3 class="text-lg font-semibold text-gray-100 mb-1">Заказ #{{ order.id }}</h3>
                <p class="text-gray-300 text-sm leading-tight">
                  {{ order.items.map(item => item.chapter.title).join(', ') }}
                </p>
              </div>
              <span class="text-gray-100 font-semibold">{{ order.total_amount }} руб.</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-400 text-sm">В обработке</span>
              <span class="text-gray-400 text-sm">{{ formatDate(order.created_at) }}</span>
            </div>
          </div>
        </div>

        <!-- Завершенные заказы -->
        <div class="mt-8">
          <h2 class="text-2xl font-mono text-gray-100 mb-6">Завершенные заказы</h2>
          
          <div class="space-y-4">
            <div 
              v-for="order in completedOrders" 
              :key="order.id"
              class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl"
            >
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-semibold text-gray-100 mb-1">Заказ #{{ order.id }}</h3>
                  <p class="text-gray-300 text-sm leading-tight">
                    {{ order.items.map(item => item.chapter.title).join(', ') }}
                  </p>
                </div>
                <span class="text-gray-100 font-semibold">{{ order.total_amount }} руб.</span>
              </div>
              <div class="mt-2">
                <span class="text-green-100 text-sm">Одобрен • {{ formatDate(order.updated_at) }}</span>
              </div>
            </div>
          </div>

          <div v-if="completedOrders.length === 0" class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-sm text-center">
            <p class="text-gray-300">Нет завершенных заказов</p>
          </div>
        </div>
      </div>

      <!-- Правая колонка - Информация пользователя -->
      <div class="lg:col-span-1">
        <!-- Блок пользователя -->
        <div class="border border-gray-500/50 rounded-lg p-6 mb-6 bg-black/20 backdrop-blur-lg shadow-2xl">
          <div class="flex items-center mb-4">
            <div class="w-20 h-20 bg-gray-400/30 backdrop-blur-sm flex items-center justify-center mr-4 border border-gray-500/50 rounded-lg">
              <span class="text-lg font-bold text-gray-100">{{ userInitials }}</span>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-gray-100">{{ user.name }}</h3>
              <p class="text-gray-300 text-sm">{{ user.email }}</p>
            </div>
          </div>
        </div>

        <!-- Меню профиля -->
        <div class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl">
          <nav class="space-y-4">
            <!-- Мой аккаунт -->
            <div>
              <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Мой аккаунт</h4>
              <div class="space-y-0.5">
                <button class="w-full text-left text-gray-300 hover:text-gray-100 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
                  Редактировать
                </button>
                <button class="w-full text-left text-gray-300 hover:text-gray-100 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
                  Способ оплаты
                </button>
              </div>
            </div>

            <div class="border-t border-gray-500/30 pt-3"></div>

            <!-- Заказы -->
            <div>
              <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Заказы</h4>
              <div class="space-y-0.5">                
                <button class="w-full text-left text-gray-300 hover:text-gray-100 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
                  Текущие заказы
                </button>
                <button class="w-full text-left text-gray-300 hover:text-gray-100 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
                  Завершенные заказы
                </button>
              </div>
            </div>

            <div class="border-t border-gray-500/30 pt-3"></div>

            <!-- Действия с аккаунтом -->
            <div class="space-y-0.5">
              <button 
                @click="logout" 
                :disabled="loading"
                class="w-full text-left text-gray-300 hover:text-gray-100 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="loading">Выход...</span>
                <span v-else>Выйти</span>
              </button>
              <button 
                @click="deleteAccount" 
                class="w-full text-left text-red-400 hover:text-red-300 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-red-500/10"
              >
                Удалить аккаунт
              </button>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['logout-success'])

const loading = ref(false)
const allOrders = ref([])

// Базовый URL API
const API_BASE_URL = 'http://localhost:8000/api'

// Загрузка заказов пользователя
const loadUserOrders = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    if (!token) {
      console.log('Токен не найден')
      return
    }

    const response = await fetch(`${API_BASE_URL}/orders/my-orders`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.ok) {
      allOrders.value = await response.json()
      console.log('Загружены заказы:', allOrders.value)
    } else {
      console.error('Ошибка загрузки заказов:', response.status)
    }
  } catch (error) {
    console.error('Error loading user orders:', error)
  }
}

// Вычисляемые свойства
const userInitials = computed(() => {
  return props.user.name?.charAt(0).toUpperCase() || 'U'
})

const pendingOrders = computed(() => {
  return allOrders.value.filter(order => order.status === 'pending')
})

const completedOrders = computed(() => {
  return allOrders.value.filter(order => order.status === 'approved')
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('ru-RU', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}

// Методы
const logout = async () => {
  if (loading.value) return
  
  loading.value = true
  
  try {
    const token = localStorage.getItem('auth_token')
    
    if (!token) {
      handleLogoutSuccess()
      return
    }

    const response = await fetch(`${API_BASE_URL}/logout`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })

    if (response.ok) {
      console.log('Успешный выход из системы')
    }
    
  } catch (error) {
    console.error('Ошибка при выходе:', error)
  } finally {
    handleLogoutSuccess()
    loading.value = false
  }
}

const handleLogoutSuccess = () => {
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user_data')
  emit('logout-success')
  window.location.href = '/login'
}

const deleteAccount = () => {
  console.log('Удаление аккаунта')
}

onMounted(() => {
  loadUserOrders()
})
</script>