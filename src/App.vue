<template>
  <div>
    <div class="global-noise"></div>

    <div class="enter-background" v-if="currentPage !== 'main'">
      <div class="enter-text">ENTER</div>
    </div>

    <Drawer 
      v-if="activeDrawerType" 
      :type="activeDrawerType" 
      @close="closeDrawer" 
      @open-payment-methods="handleOpenPaymentMethods"
    />

    <!-- Header для всех страниц -->
    <Header 
      :current-page="currentPage"
      @open-cart="openDrawer('cart')" 
      @open-profile="handleProfileClick"
      @open-catalog="showCatalogPage"
      @back="showMainPage"
    />

    <!-- Динамический контент страниц -->
    <div class="min-h-screen flex flex-col">
      <!-- Главная страница -->
      <div v-if="currentPage === 'main'" class="flex-1">
        <main>
          <!-- Герой секция -->
          <section class="border-b border-gray-500/50 py-20 px-8 relative overflow-hidden">
            <div class="max-w-4xl mx-auto text-center relative z-10">
              <h1 class="text-5xl font-mono text-gray-100 mb-6 tracking-tight">
                ENTER
              </h1>
              <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                закрытый клуб знаний и стратегий,<br>
                каждая глава — шаг в неизведанное
              </p>
              <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Уникальная книга, где весь интернет-<br>
                магазин превращён в повествование.
              </p>
            </div>
          </section>

          <!-- Преимущества -->
          <section class="py-20 px-8 border-b border-gray-500/50">
            <div class="max-w-6xl mx-auto">
              <h2 class="text-3xl font-mono text-gray-100 text-center mb-16">
                Почему стоит купить главы ENTER
              </h2>
              
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-lg shadow-2xl text-center transition-all duration-300 hover:scale-105 relative overflow-hidden">
                  <div class="noise-overlay-card-strong"></div>
                  <div class="text-4xl font-mono text-gray-100 mb-4 relative z-10">01</div>
                  <h3 class="text-xl font-semibold text-gray-100 mb-4 relative z-10">Конкретные инструменты мышления.</h3>
                </div>

                <div class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-lg shadow-2xl text-center transition-all duration-300 hover:scale-105 relative overflow-hidden">
                  <div class="noise-overlay-card-strong"></div>
                  <div class="text-4xl font-mono text-gray-100 mb-4 relative z-10">02</div>
                  <h3 class="text-xl font-semibold text-gray-100 mb-4 relative z-10">Переход на другой уровень восприятия.</h3>
                </div>

                <div class="border border-gray-500/50 rounded-lg p-8 bg-black/20 backdrop-blur-lg shadow-2xl text-center transition-all duration-300 hover:scale-105 relative overflow-hidden">
                  <div class="noise-overlay-card-strong"></div>
                  <div class="text-4xl font-mono text-gray-100 mb-4 relative z-10">03</div>
                  <h3 class="text-xl font-semibold text-gray-100 mb-4 relative z-10">Закрытый контент, не доступный публично.</h3>
                </div>
              </div>
            </div>
          </section>

          <section class="py-20 px-8 border-b border-gray-500/50">
            <div class="max-w-4xl mx-auto text-center">
              <p class="text-2xl text-gray-300 mb-6 leading-relaxed">
                Каждый день кто-то делает шаг вперёд,<br>
                а кто-то остаётся наблюдать.
              </p>
              <p class="text-2xl text-gray-100 font-semibold mb-8 leading-relaxed">
                Разница между ними — один клик.
              </p>
              <p class="text-xl text-gray-300 mb-12 leading-relaxed">
                ENTER — это шаг в сторону контроля,<br>
                понимания и силы.
              </p>
              
              <button 
                @click="showCatalogPage"
                class="bg-white text-black font-semibold py-4 px-12 rounded-lg hover:bg-gray-200 transition-all duration-300 text-lg"
              >
                Открыть первую главу
              </button>
            </div>
          </section>
        </main>
      </div>

      <!-- Страница каталога -->
      <div v-else-if="currentPage === 'catalog'" class="flex-1">
        <CatalogPage @open-chapter="showChapterDetail" />
      </div>

      <!-- Страница авторизации/регистрации -->
      <div v-else-if="currentPage === 'auth'" class="flex-1">
        <AuthPage @login-success="handleLoginSuccess" />
      </div>

      <!-- Страница профиля -->
      <div v-else-if="currentPage === 'profile'" class="flex-1">
        <ProfilePage @logout="handleLogout" />
      </div>

      <!-- Детальная страница главы -->
      <div v-else-if="currentPage === 'chapter-detail'" class="flex-1">
        <ChapterDetail 
          :chapter="selectedChapter"
          @back="showCatalogPage"
          @add-to-cart="addToCart"
        />
      </div>

      <!-- Футер -->
      <Footer />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Header from './components/Header.vue'
import CatalogPage from './components/CatalogPage.vue'
import Drawer from './components/Drawer.vue'
import ProfilePage from './components/ProfilePage.vue'
import AuthPage from './components/AuthPage.vue'
import ChapterDetail from './components/ChapterDetail.vue'
import Footer from './components/Footer.vue'

const activeDrawerType = ref(null)
const currentPage = ref('main')
const user = ref(null)
const selectedChapter = ref(null)

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

const showCatalogPage = () => {
  console.log('Opening catalog page')
  currentPage.value = 'catalog'
}

const showProfilePage = () => {
  console.log('Opening profile page')
  currentPage.value = 'profile'
}

const showAuthPage = () => {
  console.log('Opening auth page')
  currentPage.value = 'auth'
}

const showMainPage = () => {
  console.log('Opening main page')
  currentPage.value = 'main'
}

const showChapterDetail = (chapter) => {
  console.log('Opening chapter detail:', chapter)
  selectedChapter.value = chapter
  currentPage.value = 'chapter-detail'
}

const handleProfileClick = () => {
  console.log('Profile clicked, user:', user.value)
  if (!user.value) {
    showAuthPage()
  } else {
    showProfilePage()
  }
}

const handleLoginSuccess = (userData) => {
  console.log('Login success:', userData)
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

const addToCart = (chapter) => {
  console.log('Adding to cart:', chapter)
  // Здесь можно добавить логику добавления в корзину
  openDrawer('cart')
}

onMounted(() => {
  console.log('App mounted')
  fetchUser()
})
</script>