<template>
  <div class="min-h-screen p-8 flex items-center justify-center">
    <div class="max-w-md w-full">
      <!-- Авторизация -->
      <div
        v-if="currentForm === 'login'"
        class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-lg shadow-2xl"
      >
        <h2 class="text-2xl font-mono text-gray-100 mb-6 text-center">Авторизация</h2>

        <form @submit.prevent="handleLogin" class="space-y-4">
          <div>
            <label class="block text-gray-100 text-sm mb-2">Email</label>
            <input
              v-model="loginForm.email"
              type="email"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Введите email"
              required
            />
          </div>

          <div>
            <label class="block text-gray-100 text-sm mb-2">Пароль</label>
            <input
              v-model="loginForm.password"
              type="password"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Введите пароль"
              required
            />
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-white text-black font-semibold py-3 rounded-lg hover:bg-gray-200 transition-all duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed backdrop-blur-sm"
          >
            <span v-if="loading">Вход...</span>
            <span v-else>Войти</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <button
            @click="switchToRegister"
            class="text-gray-400 hover:text-gray-300 underline transition-colors duration-300"
          >
            Зарегистрироваться
          </button>
        </div>
      </div>

      <!-- Регистрация -->
      <div
        v-else
        class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-lg shadow-2xl"
      >
        <h2 class="text-2xl font-mono text-gray-100 mb-6 text-center">Регистрация</h2>

        <form @submit.prevent="handleRegister" class="space-y-4">
          <div>
            <label class="block text-gray-100 text-sm mb-2">Имя пользователя</label>
            <input
              v-model="registerForm.name"
              type="text"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Введите имя пользователя"
              required
            />
          </div>

          <div>
            <label class="block text-gray-100 text-sm mb-2">Email</label>
            <input
              v-model="registerForm.email"
              type="email"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Введите email"
              required
            />
          </div>

          <div>
            <label class="block text-gray-100 text-sm mb-2">Пароль</label>
            <input
              v-model="registerForm.password"
              type="password"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Введите пароль"
              required
            />
          </div>

          <div>
            <label class="block text-gray-100 text-sm mb-2">Подтвердите пароль</label>
            <input
              v-model="registerForm.password_confirmation"
              type="password"
              class="w-full border border-gray-500/60 text-gray-300 rounded-md py-2 px-4 bg-black/30 backdrop-blur-sm outline-none focus:border-gray-400 focus:bg-black/40 transition-all duration-300 placeholder-gray-500"
              placeholder="Подтвердите пароль"
              required
            />
          </div>

          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-white text-black font-semibold py-3 rounded-lg hover:bg-gray-200 transition-all duration-300 disabled:bg-gray-400 disabled:cursor-not-allowed backdrop-blur-sm"
          >
            <span v-if="loading">Регистрация...</span>
            <span v-else>Зарегистрироваться</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <button
            @click="switchToLogin"
            class="text-gray-400 hover:text-gray-300 underline transition-colors duration-300"
          >
            Авторизоваться
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'

const emit = defineEmits(['login-success'])
const currentForm = ref('login')
const loading = ref(false)

const loginForm = reactive({
  email: '',
  password: ''
})

const registerForm = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
})

const handleLogin = async () => {
  loading.value = true
  try {
    console.log('Начинаем авторизацию...', loginForm)

    const response = await fetch('http://localhost:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(loginForm)
    })

    console.log('Ответ сервера:', {
      status: response.status,
      statusText: response.statusText,
      ok: response.ok
    })

    const data = await response.json()
    console.log('Данные ответа:', data)

    if (!response.ok) {
      if (response.status === 401) {
        throw new Error('Неверный email или пароль')
      } else if (response.status === 422) {
        const errorMsg = data.errors ? Object.values(data.errors).flat().join(', ') : data.message
        throw new Error(errorMsg)
      } else if (response.status === 500) {
        throw new Error('Ошибка сервера. Попробуйте позже.')
      } else {
        throw new Error(data.message || `Ошибка ${response.status}`)
      }
    }

    if (data.success && data.token) {
      console.log('Авторизация успешна, токен:', data.token.substring(0, 20) + '...')
      localStorage.setItem('auth_token', data.token)
      localStorage.setItem('user_data', JSON.stringify(data.user))
      emit('login-success', data.user)
    } else {
      throw new Error(data.message || 'Неизвестная ошибка авторизации')
    }

  } catch (error) {
    console.error('Ошибка авторизации:', error)
    
    if (error.message.includes('Failed to fetch') || error.message.includes('Network')) {
      alert('Ошибка сети. Проверьте подключение к интернету и запущен ли сервер.')
    } else {
      alert(error.message || 'Ошибка при авторизации')
    }
  } finally {
    loading.value = false
  }
}

const handleRegister = async () => {
  loading.value = true
  try {
    console.log('Начинаем регистрацию...', registerForm)

    if (registerForm.password !== registerForm.password_confirmation) {
      throw new Error('Пароли не совпадают')
    }

    const response = await fetch('http://localhost:8000/api/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(registerForm)
    })

    console.log('Ответ сервера:', {
      status: response.status,
      statusText: response.statusText,
      ok: response.ok
    })

    const data = await response.json()
    console.log('Данные ответа:', data)

    if (!response.ok) {
      if (response.status === 422) {
        const errorMessages = data.errors ? Object.values(data.errors).flat().join('\n') : data.message
        throw new Error(errorMessages)
      } else if (response.status === 500) {
        throw new Error('Ошибка сервера при регистрации')
      } else {
        throw new Error(data.message || 'Ошибка регистрации')
      }
    }

    if (data.success && data.token) {
      console.log('Регистрация успешна, токен:', data.token.substring(0, 20) + '...')
      localStorage.setItem('auth_token', data.token)
      localStorage.setItem('user_data', JSON.stringify(data.user))
      emit('login-success', data.user)
    } else {
      throw new Error(data.message || 'Неизвестная ошибка регистрации')
    }

  } catch (error) {
    console.error('Ошибка регистрации:', error)
    
    if (error.message.includes('Failed to fetch') || error.message.includes('Network')) {
      alert('Ошибка сети. Проверьте подключение к интернету и запущен ли сервер.')
    } else {
      const errorMessage = error.message.includes('\n') 
        ? 'Ошибки:\n' + error.message 
        : error.message
      alert(errorMessage)
    }
  } finally {
    loading.value = false
  }
}

const switchToLogin = () => {
  currentForm.value = 'login'
  registerForm.name = ''
  registerForm.email = ''
  registerForm.password = ''
  registerForm.password_confirmation = ''
}

const switchToRegister = () => {
  currentForm.value = 'register'
  loginForm.email = ''
  loginForm.password = ''
}
</script>