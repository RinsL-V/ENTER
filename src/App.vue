<template>
  <div>
    <Drawer 
      :type="activeDrawerType" 
      @close="closeDrawer" 
    />

    <div class="bg-yellow-100 m-auto rounded-xl shadow-xl mt-3 main-div">
      <Header 
        @open-cart="openDrawer('cart')" 
        @open-profile="openDrawer('profile')" 
      />

      <div class="m-8 p-3">
        <div class="flex justify-between">
          <h2 class="text-2xl font-mono mb-6 text-amber-50">Все главы</h2>
          <div class="relative">
            <img class="absolute ml-2 mt-2" src="/src/assets/search.svg" alt="поиск">
            <input
              v-model="search"
              class="border border-amber-50 text-amber-50 rounded-md py-2 pl-10 pr-4 outline-none focus:border-amber-100"
              placeholder="Поиск..."
            />
          </div>
        </div>

        <div class="mt-10">
          <CardList :items="filteredItems" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import Header from './components/Header.vue'
import CardList from './components/CardList.vue'
import Drawer from './components/Drawer.vue'

const activeDrawerType = ref(null)
const search = ref("")
const items = ref([])

const openDrawer = (type) => {
  activeDrawerType.value = type
}

const closeDrawer = () => {
  activeDrawerType.value = null
}

const filteredItems = computed(() =>
  items.value.filter(ch =>
    ch.title.toLowerCase().includes(search.value.toLowerCase())
  )
)

async function fetchChapters() {
  try {
    const res = await fetch('http://localhost:8000/api/chapters')
    const data = await res.json()

    items.value = data.map(ch => ({
      id: ch.id,
      title: ch.title,
      description: ch.description,
      imageUrl: ch.image_url,
      price: ch.price
    }))
  } catch (err) {
    console.error('Ошибка загрузки глав:', err)
  }
}

onMounted(() => {
  fetchChapters()
})
</script>