<template>
  <header class="flex justify-between border-yellow-50 border-b px-10 py-5">
    <div class="flex items-center gap-4">
      <h2 class="text-xl cursor-pointer" @click="goHome">ENTER</h2>
    </div>

    <ul class="flex items-center gap-10 text-amber-50">      
      <li class="flex items-center gap-3 cursor-pointer">
        <a>каталог</a>
      </li>

      <li class="flex items-center gap-3 cursor-pointer" @click="$emit('open-cart')">
        <p>корзина</p>
      </li>

      <li class="flex items-center gap-3 cursor-pointer" @click="$emit('open-profile')">
        <p>профиль</p>
      </li>
    </ul>
  </header>
</template>

<script setup>
defineProps({
  showBackButton: {
    type: Boolean,
    default: false
  }
})

defineEmits(['open-cart', 'open-profile', 'back'])

const goHome = () => {
  if (window.location.hash !== '#main') {
    window.location.hash = 'main'
  }
}
</script>

<style scoped>
h2 {
  color: #FFF5B7; 
  font-size: 1.25rem; 
}
</style>