<template>
  <div class="max-w-6xl mx-auto">
    <!-- Основной контент в две колонки -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Левая колонка - Актуальные заказы -->
      <div class="lg:col-span-2">
        <h2 class="text-2xl font-mono text-amber-50 mb-6">Текущие заказы</h2>
        
        <!-- Список заказов -->
        <div class="space-y-4">
          <!-- Заказ 1 -->
          <div class="border border-amber-50 rounded-lg p-6">
            <div class="flex justify-between items-start mb-3">
              <div>
                <h3 class="text-lg font-semibold text-amber-50 mb-1">Глава 2.</h3>
                <p class="text-amber-100 text-sm leading-tight">
                  Разведывательная парадигма в корпоративной аналитике
                </p>
              </div>
              <span class="text-amber-50 font-semibold">999 руб.</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-amber-200 text-sm">В обработке</span>
              <button class="text-amber-50 hover:text-amber-100 text-sm underline">
                Подробнее
              </button>
            </div>
          </div>

          <!-- Заказ 2 -->
          <div class="border border-amber-50 rounded-lg p-6">
            <div class="flex justify-between items-start mb-3">
              <div>
                <h3 class="text-lg font-semibold text-amber-50 mb-1">Глава 3.</h3>
                <p class="text-amber-100 text-sm leading-tight">
                  Информационно-психологические операции на рынке
                </p>
              </div>
              <span class="text-amber-50 font-semibold">999 руб.</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-amber-200 text-sm">В обработке</span>
              <button class="text-amber-50 hover:text-amber-100 text-sm underline">
                Подробнее
              </button>
            </div>
          </div>

          <!-- Заказ 3 -->
          <div class="border border-amber-50 rounded-lg p-6">
            <div class="flex justify-between items-start mb-3">
              <div>
                <h3 class="text-lg font-semibold text-amber-50 mb-1">Глава 4.</h3>
                <p class="text-amber-100 text-sm leading-tight">
                  Вербовка, удержание и эксплуатация человеческого капитала
                </p>
              </div>
              <span class="text-amber-50 font-semibold">999 руб.</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-amber-200 text-sm">В обработке</span>
              <button class="text-amber-50 hover:text-amber-100 text-sm underline">
                Подробнее
              </button>
            </div>
          </div>
        </div>

        <!-- Завершенные заказы -->
        <div class="mt-8">
          <h2 class="text-2xl font-mono text-amber-50 mb-6">Завершенные заказы</h2>
          
          <div class="border border-amber-50 rounded-lg p-6">
            <div class="flex justify-between items-start">
              <div>
                <h3 class="text-lg font-semibold text-amber-50 mb-1">Глава 1.</h3>
                <p class="text-amber-100 text-sm leading-tight">
                  Скрытая архитектура глобальных и локальных рынков
                </p>
              </div>
              <span class="text-amber-50 font-semibold">999 руб.</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Правая колонка - Информация пользователя -->
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

        <!-- Меню профиля -->
        <div class="border border-amber-50 rounded-lg p-6">
          <nav class="space-y-6">
            <!-- Мой аккаунт -->
            <div>
              <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Мой аккаунт</h4>
              <div class="space-y-2">
                <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm px-3 rounded transition-colors">
                  Редактировать
                </button>
                <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm px-3 rounded transition-colors">
                  Способ оплаты
                </button>
              </div>
            </div>

            <div class="border-t border-amber-50 border-opacity-30"></div>

            <!-- Заказы -->
            <div>
              <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Заказы</h4>
              <div class="space-y-2">                
                <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm px-3 rounded transition-colors">
                  Текущие заказы
                </button>
                <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm px-3 rounded transition-colors">
                  Завершенные заказы
                </button>
              </div>
            </div>

            <div class="border-t border-amber-50 border-opacity-30"></div>

            <!-- Действия с аккаунтом -->
            <div class="space-y-2">
              <button 
                @click="logout" 
                :disabled="loading"
                class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm px-3 rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="loading">Выход...</span>
                <span v-else>Выйти</span>
              </button>
              <button 
                @click="deleteAccount" 
                class="w-full text-left text-red-400 hover:text-red-300 py-2 flex items-center text-sm px-3 rounded transition-colors"
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
import { computed, ref } from 'vue'

const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})

const emit = defineEmits(['logout-success'])

const loading = ref(false)

// Вычисляемые свойства
const userInitials = computed(() => {
  return props.user.name?.charAt(0).toUpperCase() || 'U'
})

// Методы
const logout = async () => {
  if (loading.value) return
  
  loading.value = true
  
  try {
    console.log('Выход из системы...')
    
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
    console.log('Ответ сервера:', data)

    if (response.ok && data.success) {
      console.log('Успешный выход из системы')
    } else {
      console.warn('Проблема с выходом:', data.message)
    }
    
  } catch (error) {
    console.error('Ошибка при выходе:', error)
  } finally {
    handleLogoutSuccess()
    loading.value = false
  }
}

const handleLogoutSuccess = () => {
  // Очищаем localStorage
  localStorage.removeItem('auth_token')
  localStorage.removeItem('user_data')
  
  // Эмитируем событие для родительского компонента
  emit('logout-success')
  
  // Простое перенаправление (работает без vue-router)
  window.location.href = '/login'
}

const deleteAccount = () => {
  console.log('Удаление аккаунта')
}
</script>