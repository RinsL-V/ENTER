<template>
  <section class="py-20 px-8">
    <div class="max-w-6xl mx-auto">
      <!-- Заголовок и поиск -->
      <div class="flex justify-between items-center mb-12">
        <h2 class="text-3xl font-mono text-gray-100">Все главы</h2>
        <div class="relative">
          <input
            v-model="searchQuery"
            @input="handleSearch"
            class="border border-gray-100/50 text-gray-100 rounded-lg py-3 pl-5 pr-6 outline-none focus:border-gray-300 bg-black/20 backdrop-blur-sm placeholder-gray-400 w-80 transition-all duration-300 focus:shadow-lg focus:shadow-white/10"
            placeholder="Поиск..."
          />
        </div>
      </div>

      <!-- Список карточек в виде сетки -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
        <!-- Карточка главы -->
        <div 
          v-for="item in filteredItems" 
          :key="item.id"
          class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl transition-all duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer chapter-card relative overflow-hidden"
          @click="openChapterDetail(item)"
        >
          <div class="noise-overlay-card-strong"></div>
          <!-- Заголовок главы -->
          <h3 class="text-xl font-mono text-gray-100 mb-3 relative z-10">{{ formatTitle(item.title) }}</h3>
          
          <!-- Описание -->
          <p class="text-gray-300 text-sm leading-relaxed mb-4 description-text relative z-10">
            {{ item.description }}
          </p>
          
          <!-- Цена и кнопка добавления в корзину -->
          <div class="border-t border-gray-500/30 pt-4 flex justify-between items-center relative z-10">
            <div>
              <p class="text-gray-400 text-sm mb-1">ЦЕНА:</p>
              <p class="text-2xl font-mono text-gray-100">{{ formatPrice(item.price) }} руб.</p>
            </div>
            <button 
              @click.stop="addToCart(item)"
              class="bg-white text-black font-semibold py-2 px-4 rounded-lg hover:bg-gray-200 transition-all duration-300 text-sm add-to-cart-btn"
            >
              В корзину
            </button>
          </div>
        </div>
      </div>

      <!-- Состояние пустого поиска -->
      <div 
        v-if="filteredItems.length === 0 && localItems.length > 0"
        class="text-center py-12"
      >
        <p class="text-gray-400 text-lg">Ничего не найдено по запросу "{{ searchQuery }}"</p>
      </div>

      <!-- Состояние загрузки -->
      <div 
        v-if="localLoading"
        class="text-center py-12"
      >
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-gray-400"></div>
        <p class="text-gray-400 mt-4">Загрузка глав...</p>
      </div>

      <!-- Состояние отсутствия глав -->
      <div 
        v-if="localItems.length === 0 && !localLoading"
        class="text-center py-12"
      >
        <p class="text-gray-400 text-lg">Главы временно недоступны</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

// Emits
const emit = defineEmits(['search', 'open-chapter'])

// Базовый URL API
const API_BASE_URL = 'http://localhost:8000/api'

// Local state
const searchQuery = ref('')
const localItems = ref([])
const localLoading = ref(false)

// Computed
const filteredItems = computed(() => {
  if (!searchQuery.value) {
    return localItems.value
  }
  
  const query = searchQuery.value.toLowerCase()
  return localItems.value.filter(item =>
    item.title.toLowerCase().includes(query) ||
    (item.description && item.description.toLowerCase().includes(query))
  )
})

// Methods
const handleSearch = () => {
  emit('search', searchQuery.value)
}

const formatPrice = (price) => {
  const numericPrice = typeof price === 'string' ? parseFloat(price) : price
  return new Intl.NumberFormat('ru-RU').format(numericPrice)
}

const formatTitle = (title) => {
  const match = title.match(/^(Глава\s+\d+)/)
  return match ? match[1] + '.' : title
}

const openChapterDetail = (chapter) => {
  console.log('Opening chapter detail:', chapter)
  emit('open-chapter', chapter)
}

const addToCart = (chapter) => {
  console.log('Adding to cart:', chapter)
  
  // Загружаем текущую корзину из localStorage
  const cart = JSON.parse(localStorage.getItem('cart') || '[]')
  
  // Проверяем, нет ли уже этой главы в корзине
  if (!cart.find(item => item.id === chapter.id)) {
    // Добавляем главу в корзину
    cart.push({
      id: chapter.id,
      title: chapter.title,
      description: chapter.description,
      price: parseFloat(chapter.price)
    })
    
    // Сохраняем обновленную корзину
    localStorage.setItem('cart', JSON.stringify(cart))
    
    // Можно добавить уведомление или событие для обновления счетчика корзины
    alert('Глава добавлена в корзину!')
    
    // Эмитируем событие для обновления родительского компонента
    emit('cart-updated')
  } else {
    alert('Эта глава уже в корзине!')
  }
}

// Загрузка глав из API
async function fetchChapters() {
  localLoading.value = true
  try {
    const response = await fetch(`${API_BASE_URL}/chapters`)
    
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`)
    }
    
    const data = await response.json()
    console.log('Загружены главы:', data)

    if (data && data.length > 0) {
      localItems.value = data.map(ch => ({
        id: ch.id,
        title: ch.title,
        description: ch.description,
        imageUrl: ch.image_url,
        price: ch.price
      }))
    }

  } catch (err) {
    console.error('Ошибка загрузки глав:', err)
    // Используем тестовые данные при ошибке
    localItems.value = [
      {
        id: 1,
        title: "Глава 1. Скрытая архитектура глобальных и локальных рынков",
        description: "В главе исследуются механизмы формирования и перераспределения капитала в закрытых сегментах экономики.",
        price: 999
      },
      {
        id: 2,
        title: "Глава 2. Теневые механизмы",
        description: "Анализ скрытых финансовых потоков и неформальных экономических отношений.",
        price: 899
      },
      {
        id: 3,
        title: "Глава 3. Корпоративные альянсы",
        description: "Исследование влияния крупных корпоративных структур на мировую экономику.",
        price: 799
      }
    ]
  } finally {
    localLoading.value = false
  }
}

// Lifecycle
onMounted(() => {
  fetchChapters()
})
</script>

<style scoped>
.description-text {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  line-clamp: 3;
  box-orient: vertical;
}

.chapter-card {
  position: relative;
  overflow: hidden;
}

.chapter-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.03) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
  pointer-events: none;
}

.add-to-cart-btn {
  position: relative;
  z-index: 10;
}
</style>