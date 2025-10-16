<template>
  <div class="flex items-center border border-gray-500/50 p-4 rounded-xl gap-4 bg-black/20 backdrop-blur-lg shadow-2xl">
    <img class="w-18 h-17 rounded-lg border border-gray-500/50" src="/public/card-girl.png" alt="chapter-card">

    <div class="flex flex-col flex-1">
      <p class="text-gray-100 font-semibold">Глава 1. Человек и его история</p>
      
      <div class="flex justify-between items-center mt-2">
        <b class="text-gray-100">999 руб.</b>
        <button class="border border-gray-500/60 p-1 rounded-xl opacity-60 hover:opacity-100 cursor-pointer transition-all duration-300 hover:bg-white/5">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-gray-300">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CartItem'
}
</script>

<style lang="scss" scoped>
</style>