<template>
  <div v-if="activeSection === 'payments'" class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl">
    <!-- Уведомления -->
    <div class="fixed top-4 right-4 z-50 space-y-2">
      <div 
        v-for="notification in notifications" 
        :key="notification.id"
        :class="[
          'flex items-center p-4 rounded-lg border backdrop-blur-sm transform transition-all duration-500 min-w-80',
          notification.type === 'success' ? 'bg-green-500/20 border-green-500/50 text-green-300' :
          notification.type === 'error' ? 'bg-red-500/20 border-red-500/50 text-red-300' :
          notification.type === 'warning' ? 'bg-yellow-500/20 border-yellow-500/50 text-yellow-300' :
          'bg-blue-500/20 border-blue-500/50 text-blue-300',
          notification.visible ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0'
        ]"
      >
        <!-- Иконка -->
        <div :class="[
          'w-6 h-6 rounded-full flex items-center justify-center mr-3 flex-shrink-0',
          notification.type === 'success' ? 'bg-green-500/30' :
          notification.type === 'error' ? 'bg-red-500/30' :
          notification.type === 'warning' ? 'bg-yellow-500/30' :
          'bg-blue-500/30'
        ]">
          <svg v-if="notification.type === 'success'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
          </svg>
          <svg v-else-if="notification.type === 'error'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
          <svg v-else-if="notification.type === 'warning'" class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          <svg v-else class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
          </svg>
        </div>
        
        <!-- Текст -->
        <div class="flex-1">
          <p class="text-sm font-medium">{{ notification.message }}</p>
        </div>
        
        <!-- Кнопка закрытия -->
        <button 
          @click="removeNotification(notification.id)"
          class="ml-2 text-gray-400 hover:text-gray-300 transition-colors duration-200"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <h2 class="text-2xl font-mono text-gray-100 mb-6">Управление заказами</h2>
    
    <!-- Фильтры и поиск -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
      <div class="flex-1">
        <input 
          v-model="searchQuery"
          type="text" 
          placeholder="Поиск по пользователю или главе..."
          class="w-full px-4 py-2 bg-black/30 border border-gray-500/50 rounded-lg text-gray-100 placeholder-gray-400 focus:outline-none focus:border-gray-400 transition-colors duration-300"
        >
      </div>
      <select 
        v-model="statusFilter"
        class="px-4 py-2 bg-black/30 border border-gray-500/50 rounded-lg text-gray-100 focus:outline-none focus:border-gray-400 transition-colors duration-300"
      >
        <option value="all">Все статусы</option>
        <option value="pending">Ожидают</option>
        <option value="approved">Одобрены</option>
        <option value="rejected">Отклонены</option>
      </select>
    </div>

    <!-- Статистика -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="border border-gray-500/50 rounded-lg p-4 bg-black/20 backdrop-blur-sm text-center">
        <p class="text-gray-300 text-sm">Всего заказов</p>
        <p class="text-2xl font-bold text-gray-100">{{ orders.length }}</p>
      </div>
      <div class="border border-gray-500/50 rounded-lg p-4 bg-black/20 backdrop-blur-sm text-center">
        <p class="text-gray-300 text-sm">На модерации</p>
        <p class="text-2xl font-bold text-yellow-100">{{ pendingOrdersCount }}</p>
      </div>
      <div class="border border-gray-500/50 rounded-lg p-4 bg-black/20 backdrop-blur-sm text-center">
        <p class="text-gray-300 text-sm">Обработано</p>
        <p class="text-2xl font-bold text-green-100">{{ processedOrdersCount }}</p>
      </div>
    </div>

    <!-- Список заказов -->
    <div class="space-y-4">
      <div 
        v-for="order in filteredOrders" 
        :key="order.id"
        class="border border-gray-500/50 rounded-lg p-4 bg-black/20 backdrop-blur-sm hover:border-gray-400/50 transition-colors duration-300"
      >
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <!-- Информация о заказе -->
          <div class="flex-1">
            <div class="flex items-center mb-3">
              <div class="w-8 h-8 bg-gray-400/30 backdrop-blur-sm rounded-full flex items-center justify-center mr-3 border border-gray-500/50">
                <span class="text-xs font-bold text-gray-100">{{ order.user.name.charAt(0) }}</span>
              </div>
              <div>
                <h3 class="text-gray-100 font-semibold">{{ order.user.name }}</h3>
                <p class="text-gray-300 text-sm">{{ order.user.email }}</p>
              </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-3">
              <div>
                <p class="text-gray-400">Заказ #{{ order.id }}</p>
                <p class="text-gray-100 font-semibold">{{ order.total_amount }} ₽</p>
              </div>
              <div>
                <p class="text-gray-400">Дата заказа:</p>
                <p class="text-gray-100">{{ formatDate(order.created_at) }}</p>
              </div>
            </div>

            <!-- Товары в заказе -->
            <div class="border-t border-gray-500/30 pt-3">
              <p class="text-gray-400 text-sm mb-2">Товары:</p>
              <div v-for="item in order.items" :key="item.id" class="text-gray-300 text-sm mb-1">
                • {{ item.chapter.title }} - {{ item.price }} ₽ (x{{ item.quantity }})
              </div>
            </div>
          </div>

          <!-- Кнопки действий -->
          <div v-if="order.status === 'pending'" class="flex flex-col sm:flex-row gap-2">
            <button 
              @click="approveOrder(order.id)"
              :disabled="loadingOrderId === order.id"
              class="bg-white text-black px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors duration-300 font-semibold text-sm flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span v-if="loadingOrderId === order.id">...</span>
              <span v-else>Одобрить</span>
            </button>
            <button 
              @click="rejectOrder(order.id)"
              :disabled="loadingOrderId === order.id"
              class="bg-black/30 text-gray-100 border border-gray-500/50 px-4 py-2 rounded-lg hover:bg-black/40 transition-colors duration-300 font-semibold text-sm flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span v-if="loadingOrderId === order.id">...</span>
              <span v-else>Отклонить</span>
            </button>
          </div>

          <div v-else class="text-center">
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium backdrop-blur-sm border"
                  :class="getStatusClasses(order.status)">
              {{ getStatusText(order.status) }}
            </span>
            <p class="text-gray-300 text-xs mt-1">{{ formatDate(order.updated_at) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Пустой state -->
    <div v-if="filteredOrders.length === 0" class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-sm text-center">
      <p class="text-gray-300">Заказы не найдены</p>
    </div>

    <!-- Кнопка обновления -->
    <div class="mt-6 text-center">
      <button 
        @click="loadOrders"
        class="bg-gray-500/30 text-gray-100 border border-gray-500/50 px-4 py-2 rounded-lg hover:bg-gray-500/40 transition-colors duration-300 font-semibold text-sm"
      >
        Обновить список
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'

const props = defineProps({
  activeSection: {
    type: String,
    default: 'stats'
  }
})

const orders = ref([])
const searchQuery = ref('')
const statusFilter = ref('all')
const loadingOrderId = ref(null)
const notifications = ref([])
let notificationId = 0

// Базовый URL API
const API_BASE_URL = 'http://localhost:8000/api'

// Система уведомлений
const showNotification = (message, type = 'info') => {
  const id = notificationId++
  const notification = {
    id,
    message,
    type,
    visible: true
  }
  
  notifications.value.push(notification)
  
  // Автоматическое скрытие через 4 секунды
  setTimeout(() => {
    hideNotification(id)
  }, 4000)
}

const hideNotification = (id) => {
  const notification = notifications.value.find(n => n.id === id)
  if (notification) {
    notification.visible = false
    // Удаление из DOM после анимации
    setTimeout(() => {
      notifications.value = notifications.value.filter(n => n.id !== id)
    }, 500)
  }
}

const removeNotification = (id) => {
  hideNotification(id)
}

// Загрузка заказов
const loadOrders = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    const response = await fetch(`${API_BASE_URL}/admin/orders`, {
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.ok) {
      orders.value = await response.json()
      console.log('Загружены заказы:', orders.value)
      showNotification(`Загружено ${orders.value.length} заказов`, 'success')
    } else {
      console.error('Ошибка загрузки заказов:', response.status)
      if (response.status === 403) {
        showNotification('У вас нет прав доступа к админской панели', 'error')
      } else {
        showNotification('Ошибка загрузки заказов', 'error')
      }
    }
  } catch (error) {
    console.error('Error loading orders:', error)
    showNotification('Ошибка подключения к серверу', 'error')
  }
}

// Статистика
const pendingOrdersCount = computed(() => {
  return orders.value.filter(order => order.status === 'pending').length
})

const processedOrdersCount = computed(() => {
  return orders.value.filter(order => order.status !== 'pending').length
})

// Фильтрация заказов
const filteredOrders = computed(() => {
  return orders.value.filter(order => {
    const matchesSearch = searchQuery.value === '' || 
      order.user.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      order.user.email.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      order.items.some(item => 
        item.chapter.title.toLowerCase().includes(searchQuery.value.toLowerCase())
      )
    
    const matchesStatus = statusFilter.value === 'all' || order.status === statusFilter.value
    
    return matchesSearch && matchesStatus
  })
})

// Действия с заказами
const approveOrder = async (orderId) => {
  try {
    loadingOrderId.value = orderId
    const token = localStorage.getItem('auth_token')
    const response = await fetch(`${API_BASE_URL}/admin/orders/${orderId}/approve`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.ok) {
      await loadOrders()
      showNotification('Заказ успешно одобрен!', 'success')
    } else {
      const errorData = await response.json().catch(() => ({}))
      console.error('Ошибка одобрения заказа:', response.status, errorData)
      showNotification(`Ошибка одобрения заказа: ${errorData.message || response.status}`, 'error')
    }
  } catch (error) {
    console.error('Error approving order:', error)
    showNotification('Ошибка при одобрении заказа', 'error')
  } finally {
    loadingOrderId.value = null
  }
}

const rejectOrder = async (orderId) => {
  try {
    loadingOrderId.value = orderId
    const token = localStorage.getItem('auth_token')
    const response = await fetch(`${API_BASE_URL}/admin/orders/${orderId}/reject`, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })
    
    if (response.ok) {
      await loadOrders()
      showNotification('Заказ отклонен!', 'warning')
    } else {
      const errorData = await response.json().catch(() => ({}))
      console.error('Ошибка отклонения заказа:', response.status, errorData)
      showNotification(`Ошибка отклонения заказа: ${errorData.message || response.status}`, 'error')
    }
  } catch (error) {
    console.error('Error rejecting order:', error)
    showNotification('Ошибка при отклонении заказа', 'error')
  } finally {
    loadingOrderId.value = null
  }
}

// Вспомогательные функции
const getStatusText = (status) => {
  const statusMap = {
    'pending': 'Ожидает рассмотрения',
    'approved': 'Одобрен',
    'rejected': 'Отклонен'
  }
  return statusMap[status] || status
}

const getStatusClasses = (status) => {
  const classes = {
    'pending': 'bg-yellow-500/20 text-yellow-300 border-yellow-500/30',
    'approved': 'bg-green-500/20 text-green-300 border-green-500/30',
    'rejected': 'bg-red-500/20 text-red-300 border-red-500/30'
  }
  return classes[status] || 'bg-gray-500/20 text-gray-300'
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('ru-RU', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Следим за изменением активной секции и загружаем заказы при необходимости
watch(() => props.activeSection, (newSection) => {
  if (newSection === 'payments') {
    loadOrders()
  }
})

onMounted(() => {
  if (props.activeSection === 'payments') {
    loadOrders()
  }
})
</script>