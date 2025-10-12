<template>
  <!-- Динамический контент в зависимости от выбранного раздела -->
  <div v-if="activeSection === 'stats'" class="border border-amber-50 rounded-lg p-6">
    <h2 class="text-2xl font-mono mb-6">Статистика продаж</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
      <div class="bg-amber-50 bg-opacity-10 p-4 rounded-lg border border-amber-100">
        <p class="text-sm">Общий доход</p>
        <p class="text-2xl font-bold">154,200 ₽</p>
      </div>
      <div class="bg-amber-50 bg-opacity-10 p-4 rounded-lg border border-amber-100">
        <p class="text-sm">Продажи за месяц</p>
        <p class="text-2xl font-bold">42</p>
      </div>
      <div class="bg-amber-50 bg-opacity-10 p-4 rounded-lg border border-amber-100">
        <p class="text-sm">Новые пользователи</p>
        <p class="text-2xl font-bold">18</p>
      </div>
    </div>
    <div class="bg-amber-50 bg-opacity-5 p-6 rounded-lg border border-amber-100">
      <p class="text-center">График аналитики продаж</p>
    </div>
  </div>

  <div v-else-if="activeSection === 'chapters'" class="border border-amber-50 rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-mono text-amber-50">Управление главами</h2>
      <button class="bg-amber-50 text-black px-4 py-2 rounded-lg hover:bg-amber-100 transition-colors">
        + Добавить главу
      </button>
    </div>
    <div class="space-y-4">
      <div v-for="chapter in chapters" :key="chapter.id" class="border border-amber-50 rounded-lg p-4 flex justify-between items-center">
        <div>
          <h3 class="text-amber-50 font-semibold">{{ chapter.title }}</h3>
          <p class="text-amber-100 text-sm">{{ chapter.price }} ₽</p>
        </div>
        <div class="flex space-x-2">
          <button class="text-amber-50 hover:text-amber-100 text-sm underline">Редактировать</button>
          <button class="text-red-400 hover:text-red-300 text-sm underline">Удалить</button>
        </div>
      </div>
    </div>
  </div>

  <div v-else-if="activeSection === 'users'" class="border border-amber-50 rounded-lg p-6">
    <h2 class="text-2xl font-mono text-amber-50 mb-6">Список пользователей</h2>
    <div class="space-y-4">
      <div v-for="userItem in users" :key="userItem.id" class="border border-amber-50 rounded-lg p-4 flex justify-between items-center">
        <div class="flex items-center">
          <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center mr-3">
            <span class="text-xs font-bold text-amber-600">{{ userItem.name.charAt(0) }}</span>
          </div>
          <div>
            <h3 class="text-amber-50 font-semibold">{{ userItem.name }}</h3>
            <p class="text-amber-100 text-sm">{{ userItem.email }}</p>
          </div>
        </div>
        <span class="text-amber-200 text-sm bg-amber-500 bg-opacity-20 px-2 py-1 rounded">
          {{ userItem.role }}
        </span>
      </div>
    </div>
  </div>

  <!-- Заглушки для других разделов -->
  <div v-else class="border border-amber-50 rounded-lg p-6">
    <h2 class="text-2xl font-mono text-amber-50 mb-6">{{ getSectionTitle(activeSection) }}</h2>
    <div class="bg-amber-50 bg-opacity-5 p-8 rounded-lg border border-amber-100 text-center">
      <p>Контент раздела находится в разработке</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  activeSection: {
    type: String,
    default: 'stats'
  },
  user: {
    type: Object,
    required: true
  }
})

// Тестовые данные
const chapters = ref([
  { id: 1, title: 'Глава 1: Введение в аналитику', price: 999 },
  { id: 2, title: 'Глава 2: Продвинутые методы', price: 1299 },
  { id: 3, title: 'Глава 3: Кейсы и практика', price: 1499 }
])

const users = ref([
  { id: 1, name: 'Атлант', email: 'human@test', role: 'user' },
  { id: 2, name: 'Мария', email: 'maria@test', role: 'user' },
  { id: 3, name: 'Алексей', email: 'alex@test', role: 'user' }
])

// Методы
const getSectionTitle = (section) => {
  const titles = {
    'orders': 'Управление заказами',
    'payments': 'Управление оплатами',
    'stats': 'Статистика продаж',
    'chapters': 'Управление главами',
    'discounts': 'Скидки и акции',
    'banners': 'Баннеры и промо',
    'settings': 'Общие настройки',
    'security': 'Безопасность',
    'users': 'Список пользователей',
    'roles': 'Роли и права доступа'
  }
  return titles[section] || 'Административная панель'
}
</script>