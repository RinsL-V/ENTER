<template>
  <div class="h-full flex flex-col">
    <!-- Список товаров -->
    <div class="flex-1 overflow-y-auto">
      <div class="space-y-4">
    <div class="flex justify-between items-start p-4 rounded-lg card">
      <div class="flex items-start gap-3 flex-1">
        <img src="/public/card-girl.png" alt="Глава 1" class="w-16 h-16 rounded-lg object-cover">
        <div>
          <h3 class="font-semibold text-lg">Глава 1</h3>
          <p class="text-gray-600 mt-1">Человек и его история</p>
          <p class="font-semibold text-lg mt-2">999 руб.</p>
        </div>
      </div>
      <div class="flex items-center">
        <button class="text-grey-500 hover:text-red-900 transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

      <div class="flex justify-between items-start p-4 card rounded-lg">
    <div class="flex items-start gap-3 flex-1">
      <img src="/public/card-girl2.png" alt="Глава 2" class="w-16 h-16 rounded-lg object-cover">
      <div>
        <h3 class="font-semibold text-lg">Глава 2</h3>
        <p class="text-gray-600 mt-1">Первородное могущество</p>
        <p class="font-semibold text-lg mt-2">1299 руб.</p>
      </div>
    </div>
    <div class="flex items-center">
      <button class="text-grey-500 hover:text-red-900 transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </div>

        
      </div>
    </div>

    <div class="border-t pt-6 mt-6">
      <div class="flex justify-between items-center mb-6">
        <span class="text-lg">Итого</span>
        <div class="flex items-center gap-2">
          <span class="flex-1 border-b border-dashed border-gray-300"></span>
          <span class="font-bold text-xl">2 298 руб.</span>
        </div>
      </div>
      
      <button class="mt-4 transition hover:bg-red-950 active:bg-neutral-900 bg-black disabled:bg-gray-300 w-full rounded-xl py-3 text-amber-50 cursor-pointer">
        Перейти к оформлению
      </button>
    </div>
  </div>
</template>

<style scope>
.card {
  background-color: #F2F0E4;
}
</style>

<script setup>
</script>