<template>
  <div class="min-h-screen p-8">
    <div v-if="loading" class="text-amber-50 text-center">
      Загрузка профиля...
    </div>
    
    <div v-else-if="error" class="text-red-400 text-center">
      {{ error }}
      <button @click="loadUserData" class="ml-4 text-amber-200 underline">
        Попробовать снова
      </button>
    </div>
    
    <div v-else-if="user && user.role === 'admin'">
      <AdminProfile 
        :user="user"
        @logout-success="emit('logout')"
      />
    </div>
    
    <div v-else-if="user">
      <UserProfile 
        :user="user"
        @logout-success="emit('logout')"
      />
    </div>
    
    <div v-else class="text-amber-50 text-center">
      Пользователь не найден
    </div>
  </div>
</template>

<script setup>
import { API_BASE_URL } from '../api.js'
import { ref, onMounted } from 'vue'
import AdminProfile from './AdminProfile.vue'
import UserProfile from './UserProfile.vue'

const emit = defineEmits(['logout', 'open-auth'])

const user = ref(null)
const loading = ref(true)
const error = ref('')

const loadUserData = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const token = localStorage.getItem('auth_token')
    
    if (!token) {
      emit('open-auth')
      return
    }

    const response = await fetch(`${API_BASE_URL}/me`, {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
      }
    })

    console.log('📨 Ответ от /api/me:', {
      status: response.status,
      statusText: response.statusText
    })

    if (!response.ok) {
      if (response.status === 401) {
        localStorage.removeItem('auth_token')
        emit('open-auth')
        return
      }
      throw new Error(`HTTP error! status: ${response.status}`)
    }

    const data = await response.json()
    console.log('Данные пользователя:', data)

    if (data.success && data.user) {
      user.value = data.user
      console.log('Роль пользователя:', user.value.role)
    } else {
      throw new Error(data.message || 'Ошибка загрузки данных пользователя')
    }
    
  } catch (err) {
    console.error('Ошибка загрузки профиля:', err)
    error.value = `Ошибка загрузки профиля: ${err.message}`
    
    // Если ошибка сети или сервера, очищаем токен
    if (err.message.includes('Failed to fetch') || err.message.includes('Network')) {
      localStorage.removeItem('auth_token')
      emit('open-auth')
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadUserData()
})
</script>
