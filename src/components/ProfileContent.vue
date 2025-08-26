<template>
  <div class="h-full flex flex-col">
    <div class="space-y-6 flex-1">
      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-sm font-medium text-gray-600">Имя</label>
          <button class="text-gray-400 hover:text-gray-600 transition-colors">
            <img :src=editIcon alt="Редактировать" class="w-5 h-5 cursor-pointer">
          </button>
        </div>
        <div class="p-3 border border-gray-300 rounded-lg">
          <p class="text-gray-900">Нефертити</p>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-sm font-medium text-gray-600">Email</label>
          <button class="text-gray-400 hover:text-gray-600 transition-colors">
            <img :src=editIcon alt="Редактировать" class="w-5 h-5 cursor-pointer">
          </button>
        </div>
        <div class="p-3 border border-gray-300 rounded-lg">
          <p class="text-gray-900">egypt@test</p>
        </div>
      </div>
    </div>

    <div class="border-t pt-6 mt-auto">
      <button class="mt-4 transition hover:bg-red-950 active:bg-neutral-900 bg-black disabled:bg-gray-300 w-full rounded-xl py-3 text-amber-50 cursor-pointer">
        Выйти
      </button>
    </div>
  </div>
</template>

<script setup>
  import editIcon from '../assets/edit.svg';
</script>