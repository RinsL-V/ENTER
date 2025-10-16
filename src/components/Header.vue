<template>
  <header class="flex justify-between items-center border-b border-gray-500/50 px-10 py-2 bg-black/20 backdrop-blur-lg shadow-2xl">
    <div class="flex items-center gap-4">
      <h2 
        v-if="!showBackButton"
        class="text-xl cursor-pointer text-gray-100 font-mono hover:text-white transition-colors duration-300" 
        @click="goHome"
      >
        ENTER
      </h2>
      <button 
        v-else
        @click="$emit('back')"
        class="text-gray-300 hover:text-white transition-colors duration-300"
      >
        ← Назад
      </button>
    </div>

    <ul class="flex items-center gap-10">      
      <li 
        class="flex items-center gap-3 cursor-pointer group" 
        @click="handleCatalogClick"
      >
        <a class="text-gray-300 hover:text-white transition-colors duration-300 group-hover:bg-white/5 px-3 py-2 rounded-lg">
          каталог
        </a>
      </li>

      <li 
        class="flex items-center gap-3 cursor-pointer group" 
        @click="$emit('open-cart')"
      >
        <p class="text-gray-300 hover:text-white transition-colors duration-300 group-hover:bg-white/5 px-3 py-2 rounded-lg">
          корзина
        </p>
      </li>

      <li 
        class="flex items-center gap-3 cursor-pointer group" 
        @click="$emit('open-profile')"
      >
        <p class="text-gray-300 hover:text-white transition-colors duration-300 group-hover:bg-white/5 px-3 py-2 rounded-lg">
          профиль
        </p>
      </li>
    </ul>
  </header>
</template>

<script setup>
defineProps({
  showBackButton: {
    type: Boolean,
    default: false
  },
  currentPage: {
    type: String,
    default: 'main'
  }
})

const emit = defineEmits(['open-cart', 'open-profile', 'open-catalog', 'back'])

const goHome = () => {
  emit('back')
}

const handleCatalogClick = () => {
  console.log('Catalog clicked in header')
  emit('open-catalog')
}
</script>

<style scoped>
header {
  position: sticky;
  top: 0;
  z-index: 40;
}
</style>