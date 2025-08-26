<template>
  <header class="flex justify-between border-yellow-50 border-b px-10 py-8">
    <div class="flex items-center gap-4">
      <h2 class="text-xl">ART OF BEING A WOMAN</h2>
    </div>

    <ul class="flex items-center gap-10">      
      <li class="flex items-center gap-3 cursor-pointer">
        <img src="/src/assets/favorite.svg" alt="like" width="25em" class="hover:filter hover:brightness-0 hover:saturate-0 hover:hue-rotate-60 hover:invert">
      </li>

      <li class="flex items-center gap-3 cursor-pointer" @click="$emit('open-cart')">
        <img src="/src/assets/cart.svg" alt="cart" width="25em" class="hover:filter hover:brightness-0 hover:saturate-0 hover:hue-rotate-60 hover:invert">
      </li>

      <li class="flex items-center gap-3 cursor-pointer" @click="$emit('open-profile')">
        <img src="/src/assets/profile.svg" alt="profile" width="25em" class="hover:filter hover:brightness-0 hover:saturate-0 hover:hue-rotate-60 hover:invert">
      </li>
    </ul>
  </header>
</template>

<script setup>
defineEmits(['open-cart', 'open-profile'])
</script>

<style scoped>
h2 {
  color: #FFF5B7; 
  font-size: 1.25rem; 
}
</style>