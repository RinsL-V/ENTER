<template>
  <div class="border border-gray-500/50 rounded-lg p-6 bg-black/20 backdrop-blur-lg shadow-2xl">
    <nav class="space-y-4">
      <!-- Личный кабинет -->
      <div>
        <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Личный кабинет</h4>
        <div class="space-y-0.5">
          <button 
            @click="handleSectionChange('account')"
            :class="activeSection === 'account' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Мой аккаунт
          </button>
          <button 
            @click="handleSectionChange('edit')"
            :class="activeSection === 'edit' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Редактировать
          </button>
        </div>
      </div>

      <div class="border-t border-gray-500/30 pt-3"></div>

      <!-- Продажи и аналитика -->
      <div>
        <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Продажи и аналитика</h4>
        <div class="space-y-0.5">
          <button 
            @click="handleSectionChange('orders')"
            :class="activeSection === 'orders' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Заказы
          </button>
          <button 
            @click="handleSectionChange('payments')"
            :class="activeSection === 'payments' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Управление оплатами
          </button>
          <button 
            @click="handleSectionChange('stats')"
            :class="activeSection === 'stats' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Статистика продаж
          </button>
        </div>
      </div>

      <!-- Маркетинг и контент -->
      <div>
        <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Маркетинг и контент</h4>
        <div class="space-y-0.5">
          <button 
            @click="handleSectionChange('chapters')"
            :class="activeSection === 'chapters' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Главы (товары)
          </button>
          <button 
            @click="handleSectionChange('discounts')"
            :class="activeSection === 'discounts' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Скидки и акции
          </button>
          <button 
            @click="handleSectionChange('banners')"
            :class="activeSection === 'banners' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Баннеры / промо
          </button>
        </div>
      </div>

      <!-- Настройки системы -->
      <div>
        <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Настройки системы</h4>
        <div class="space-y-0.5">
          <button 
            @click="handleSectionChange('settings')"
            :class="activeSection === 'settings' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Общие настройки
          </button>
          <button 
            @click="handleSectionChange('security')"
            :class="activeSection === 'security' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Безопасность
          </button>
        </div>
      </div>

      <!-- Пользователи -->
      <div>
        <h4 class="text-gray-100 font-semibold mb-1 text-sm uppercase tracking-wider">Пользователи</h4>
        <div class="space-y-0.5">
          <button 
            @click="handleSectionChange('users')"
            :class="activeSection === 'users' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Список пользователей
          </button>
          <button 
            @click="handleSectionChange('roles')"
            :class="activeSection === 'roles' ? 'bg-white/10 text-white' : 'text-gray-300 hover:text-white'"
            class="w-full text-left py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
            Роли и права доступа
          </button>
        </div>
      </div>

      <div class="border-t border-gray-500/30 pt-3"></div>

      <!-- Действия с аккаунтом -->
      <div class="space-y-0.5">
        <button 
          @click="handleLogout" 
          class="w-full text-left text-gray-300 hover:text-white py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-white/5">
          Выйти
        </button>
        <button class="w-full text-left text-red-400 hover:text-red-300 py-0.5 flex items-center text-sm px-3 rounded transition-colors duration-300 hover:bg-red-500/10">
          Удалить аккаунт
        </button>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { nextTick } from 'vue'

defineProps({
  activeSection: {
    type: String,
    default: 'stats'
  }
})

const emit = defineEmits(['section-change', 'logout'])

const handleSectionChange = (section) => {
  // Эмитим событие смены секции
  emit('section-change', section)
  
  // Прокручиваем к началу страницы
  scrollToTop()
}

const handleLogout = () => {
  // Прокручиваем к началу перед выходом (опционально)
  scrollToTop()
  emit('logout')
}

const scrollToTop = () => {
  nextTick(() => {
    window.scrollTo({
      top: 0,
      left: 0,
      behavior: 'smooth'
    })
  })
}
</script>