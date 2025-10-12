<template>
  <div class="max-w-7xl mx-auto">
    <!-- Основной контент в две колонки -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Левая колонка - Меню админа -->
      <div class="lg:col-span-1">
        <!-- Блок пользователя -->
        <div class="border border-amber-50 rounded-lg p-6 mb-6">
          <div class="flex items-center mb-4">
            <div class="w-20 h-20 bg-amber-100 flex items-center justify-center mr-4 border border-amber-200">
              <span class="text-lg font-bold text-amber-600">{{ userInitials }}</span>
            </div>
            <div>
              <h3 class="text-lg font-semibold text-amber-50">{{ user.name }}</h3>
              <p class="text-amber-100 text-sm">{{ user.email }}</p>
            </div>
          </div>
        </div>

        <!-- Меню админа -->
        <AdminMenu 
          :active-section="activeSection"
          @section-change="setActiveSection"
          @logout="logout"
        />
      </div>

      <!-- Правая колонка - Контент админа -->
      <div class="lg:col-span-3">
        <AdminContent 
          :active-section="activeSection"
          :user="user"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import AdminMenu from './AdminMenu.vue'
import AdminContent from './AdminContent.vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['logout-success'])

// Активный раздел
const activeSection = ref('stats')

// Вычисляемые свойства
const userInitials = computed(() => {
  return props.user.name?.charAt(0).toUpperCase() || 'A'
})

// Методы
const setActiveSection = (section) => {
  activeSection.value = section
}

const logout = async () => {
  try {
    console.log('🔄 Выход из системы...')
    
    const token = localStorage.getItem('auth_token')
    
    if (!token) {
      console.warn('Токен не найден')
      handleLogoutSuccess()
      return
    }

    // Отправляем запрос на сервер для выхода
    const response = await fetch('http://localhost:8000/api/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      }
    })

    const data = await response.json()
    console.log('📨 Ответ сервера при выходе:', data)

    if (response.ok && data.success) {
      console.log('Успешный выход из системы')
    } else {
      console.warn('Проблема с выходом на сервере:', data.message)
    }
    
  } catch (error) {
    console.error('Ошибка при выходе:', error)
  } finally {
    // Всегда очищаем данные на клиенте
    handleLogoutSuccess()
  }
}

const handleLogoutSuccess = () => {
  // Очищаем localStorage
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user_data')
  
  // Эмитируем событие для родительского компонента
  emit('logout-success')
  
  // Перенаправляем на страницу входа
  window.location.href = '/login'
}
</script>