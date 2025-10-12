<template>
  <div class="border border-amber-50 rounded-lg p-6">
    <nav class="space-y-6">
      <!-- Личный кабинет -->
      <div>
        <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Личный кабинет</h4>
        <div class="space-y-2">
          <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm">
            Мой аккаунт
          </button>
          <button class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm">
            Редактировать
          </button>
        </div>
      </div>

      <div class="border-t border-amber-50 border-opacity-30"></div>

      <!-- Продажи и аналитика -->
      <div>
        <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Продажи и аналитика</h4>
        <div class="space-y-2">
          <button 
            @click="$emit('section-change', 'orders')"
            :class="activeSection === 'orders' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Заказы
          </button>
          <button 
            @click="$emit('section-change', 'payments')"
            :class="activeSection === 'payments' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Управление оплатами
          </button>
          <button 
            @click="$emit('section-change', 'stats')"
            :class="activeSection === 'stats' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Статистика продаж
          </button>
        </div>
      </div>

      <!-- Маркетинг и контент -->
      <div>
        <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Маркетинг и контент</h4>
        <div class="space-y-2">
          <button 
            @click="$emit('section-change', 'chapters')"
            :class="activeSection === 'chapters' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Главы (товары)
          </button>
          <button 
            @click="$emit('section-change', 'discounts')"
            :class="activeSection === 'discounts' ? ' bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Скидки и акции
          </button>
          <button 
            @click="$emit('section-change', 'banners')"
            :class="activeSection === 'banners' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Баннеры / промо
          </button>
        </div>
      </div>

      <!-- Настройки системы -->
      <div>
        <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Настройки системы</h4>
        <div class="space-y-2">
          <button 
            @click="$emit('section-change', 'settings')"
            :class="activeSection === 'settings' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
             Общие настройки
          </button>
          <button 
            @click="$emit('section-change', 'security')"
            :class="activeSection === 'security' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
            Безопасность
          </button>
        </div>
      </div>

      <!-- Пользователи -->
      <div>
        <h4 class="text-amber-50 font-semibold mb-3 text-sm uppercase tracking-wider">Пользователи</h4>
        <div class="space-y-2">
          <button 
            @click="$emit('section-change', 'users')"
            :class="activeSection === 'users' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
             Список пользователей
          </button>
          <button 
            @click="$emit('section-change', 'roles')"
            :class="activeSection === 'roles' ? 'bg-amber-50 bg-opacity-10' : 'text-amber-50 hover:text-amber-100'"
            class="w-full text-left py-2 flex items-center text-sm px-3 rounded transition-colors">
             Роли и права доступа
          </button>
        </div>
      </div>

      <div class="border-t border-amber-50 border-opacity-30"></div>

      <!-- Действия с аккаунтом -->
      <div class="space-y-2">
        <button @click="$emit('logout')" class="w-full text-left text-amber-50 hover:text-amber-100 py-2 flex items-center text-sm">
          Выйти
        </button>
        <button class="w-full text-left text-red-400 hover:text-red-300 py-2 flex items-center text-sm">
          Удалить аккаунт
        </button>
      </div>
    </nav>
  </div>
</template>

<script setup>
defineProps({
  activeSection: {
    type: String,
    default: 'stats'
  }
})

defineEmits(['section-change', 'logout'])
</script>