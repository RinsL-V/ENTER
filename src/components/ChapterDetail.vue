<template>
  <div class="min-h-screen py-12 px-6">
    <div class="max-w-3xl mx-auto">
      <!-- Кнопка назад -->
      <button 
        @click="$emit('back')"
        class="flex items-center text-gray-400 hover:text-gray-300 mb-6 transition-colors duration-300 group"
      >
        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Назад к каталогу
      </button>

      <!-- Карточка главы -->
      <div class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-xl glass-effect">
        <!-- Заголовок -->
        <h1 class="text-2xl font-mono text-gray-100 mb-4">{{ chapter.title }}</h1>
        
        <!-- Описание -->
        <div class="prose prose-invert max-w-none mb-6">
          <p class="text-gray-300 text-base leading-relaxed">{{ chapter.description }}</p>
        </div>

        <!-- Дополнительный контент -->
        <div class="border-t border-gray-500/30 pt-4 mb-6">
          <p class="text-gray-400 text-xs mb-2">СОДЕРЖАНИЕ ГЛАВЫ:</p>
          <ul class="text-gray-300 text-sm list-disc list-inside space-y-1">
            <li>Анализ скрытых механизмов рынка</li>
            <li>Современная интерпретация "невидимой руки"</li>
            <li>Влияние негосударственных игроков</li>
            <li>Взаимосвязь формальных и теневых практик</li>
          </ul>
        </div>

        <!-- Цена и кнопки действий -->
        <div class="border-t border-gray-500/30 pt-4">
          <div class="flex justify-between items-center">
            <div>
              <p class="text-gray-400 text-xs mb-1">ЦЕНА:</p>
              <p class="text-2xl font-mono text-gray-100">{{ formatPrice(chapter.price) }} руб.</p>
            </div>
            <div class="flex space-x-3">
              <button 
                @click="addToCart"
                class="bg-white text-black font-semibold py-2 px-6 rounded-lg hover:bg-gray-200 transition-all duration-300 text-base"
              >
                Добавить в корзину
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  chapter: {
    type: Object,
    required: true,
    default: () => ({
      id: null,
      title: '',
      description: '',
      price: 0
    })
  }
})

const emit = defineEmits(['back'])

const formatPrice = (price) => {
  const numericPrice = typeof price === 'string' ? parseFloat(price) : price
  return new Intl.NumberFormat('ru-RU').format(numericPrice)
}

const addToCart = () => {
  // Загружаем текущую корзину из localStorage
  const cart = JSON.parse(localStorage.getItem('cart') || '[]')
  
  // Проверяем, нет ли уже этой главы в корзине
  if (!cart.find(item => item.id === props.chapter.id)) {
    // Добавляем главу в корзину
    cart.push({
      id: props.chapter.id,
      title: props.chapter.title,
      description: props.chapter.description,
      price: parseFloat(props.chapter.price)
    })
    
    // Сохраняем обновленную корзину
    localStorage.setItem('cart', JSON.stringify(cart))
    
    alert('Глава добавлена в корзину!')
  } else {
    alert('Эта глава уже в корзине!')
  }
}
</script>

<style scoped>
.glass-effect {
  position: relative;
  overflow: hidden;
}

.glass-effect::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='1' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.1'/%3E%3C/svg%3E"),
    radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.03) 0%, transparent 50%);
  pointer-events: none;
  mix-blend-mode: overlay;
}
</style>