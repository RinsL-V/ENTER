<template>
  <div>
    <div v-if="currentPage !== 'main'" class="enter-background">
      <div class="enter-text">ENTER</div>
    </div>

    <Drawer 
      v-if="activeDrawerType" 
      :type="activeDrawerType" 
      @close="closeDrawer" 
      @open-payment-methods="handleOpenPaymentMethods"
    />

    <div v-if="currentPage === 'main'">
      <Header 
        @open-cart="openDrawer('cart')" 
        @open-profile="handleProfileClick"
      />

      <div class="p-8">
        <div class="flex justify-between">
          <h2 class="text-2xl font-mono mb-6 text-amber-50">Все главы</h2>
          <div class="relative">
            <img class="absolute ml-2 mt-2" src="/src/assets/search.svg" alt="поиск">
            <input
              v-model="search"
              class="border border-amber-50 text-amber-50 rounded-md py-2 pl-10 pr-4 outline-none focus:border-amber-100 bg-transparent"
              placeholder="Поиск..."
            />
          </div>
        </div>

        <div class="mt-10">
          <CardList :items="filteredItems" />
        </div>
      </div>
    </div>

    <!-- Страница авторизации/регистрации -->
    <div v-if="currentPage === 'auth'">
      <Header 
        @open-cart="openDrawer('cart')" 
        @open-profile="handleProfileClick"
        :show-back-button="true"
        @back="showMainPage"
      />
      
      <AuthPage @login-success="handleLoginSuccess" />
    </div>

    <!-- Страница профиля -->
    <div v-if="currentPage === 'profile'">
      <Header 
        @open-cart="openDrawer('cart')" 
        @open-profile="handleProfileClick"
        :show-back-button="true"
        @back="showMainPage"
      />
      
      <ProfilePage @logout="handleLogout" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Header from './components/Header.vue'
import CardList from './components/CardList.vue'
import Drawer from './components/Drawer.vue'
import ProfilePage from './components/ProfilePage.vue'
import AuthPage from './components/AuthPage.vue'

const activeDrawerType = ref(null)
const currentPage = ref('main')
const search = ref("")
const items = ref([])
const user = ref(null)
const loading = ref(false)

// Загрузка данных пользователя
const fetchUser = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    
    if (!token) {
      console.log('No token found')
      return
    }

    const response = await fetch('http://localhost:8000/api/me', {
      method: 'GET',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    })

    const data = await response.json()
    
    if (response.status === 401) {
      // Токен невалидный
      localStorage.removeItem('auth_token')
      user.value = null
      return
    }

    if (!response.ok) {
      throw new Error(data.message || 'Failed to fetch user')
    }

    if (data.success) {
      user.value = data.user
    }
  } catch (error) {
    console.error('Ошибка загрузки пользователя:', error)
    localStorage.removeItem('auth_token')
    user.value = null
  }
}

const openDrawer = (type) => {
  activeDrawerType.value = type
}

const closeDrawer = () => {
  activeDrawerType.value = null
}

const showProfilePage = () => {
  currentPage.value = 'profile'
}

const showAuthPage = () => {
  currentPage.value = 'auth'
}

const showMainPage = () => {
  currentPage.value = 'main'
}

const handleProfileClick = () => {
  if (!user.value) {
    showAuthPage()
  } else {
    showProfilePage()
  }
}

const handleLoginSuccess = (userData) => {
  user.value = userData
  showProfilePage()
}

const handleLogout = async () => {
  try {
    const token = localStorage.getItem('auth_token')
    
    const response = await fetch('http://localhost:8000/api/logout', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    })

    const data = await response.json()
    
    if (data.success) {
      localStorage.removeItem('auth_token')
      user.value = null
      showMainPage()
    }
  } catch (error) {
    console.error('Ошибка выхода:', error)
    localStorage.removeItem('auth_token')
    user.value = null
    showMainPage()
  }
}

const handleOpenPaymentMethods = () => {
  showProfilePage()
}

const filteredItems = computed(() =>
  items.value.filter(ch =>
    ch.title.toLowerCase().includes(search.value.toLowerCase())
  )
)

async function fetchChapters() {
  try {
    const response = await fetch('http://localhost:8000/api/chapters')
    const data = await response.json()

    items.value = data.map(ch => ({
      id: ch.id,
      title: ch.title,
      description: ch.description,
      imageUrl: ch.image_url,
      price: Number(ch.price)
    }))
  } catch (err) {
    console.error('Ошибка загрузки глав:', err)
  }
}

onMounted(() => {
  fetchChapters()
  fetchUser()
})
</script>