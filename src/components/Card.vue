<template>
  <div>
    <div class="relative cursor-pointer rounded-xl transition hover:-translate-y-2 chapter-card">
      <img 
        src="/src/assets/liked.svg" 
        alt="liked" 
        class="absolute top-4 left-2 w-8 h-8"  
      >
      <img 
          @click="onClickFavorite"
          :src="isFavorite ? likedIcon : notLikedIcon " 
          alt="Added" 
          class="absolute top-4 left-2 w-8 h-8"  
        >

      <div class="flex justify-center pt-5">
        <img :src="imageUrl" alt="chapter-card">
      </div>

      <p class="mt-3 ml-5 mr-5">{{ title }}</p>
      <p class="mt-1 ml-5 mr-5 text-sm text-gray-900">{{ description }}</p>


      <div class="flex justify-between items-center mt-5 ml-3 mr-4 mb-3">
        <div class="flex flex-col mb-4">
          <span>Цена: {{ price }} руб.</span>
        </div>

        <img 
          @click="onClickAdd"
          :src="isAdded ? plusIcon : addedIcon " 
          alt="Added" 
          class="w-8 h-8 mb-3"  
        >
      </div>
    </div>
  </div>
</template>

<script setup>
  import { inject } from 'vue';
  import plusIcon from '../assets/plus.svg';
  import addedIcon from '../assets/added.svg';
  import likedIcon from '../assets/liked.svg';
  import notLikedIcon from '../assets/notLiked.svg';


  defineProps({   
    id: Number, 
    imageUrl: String,
    title: String,
    description: String,
    price: Number,
    isFavorite: Boolean,
    isAdded: Boolean,
    onClickAdd: Function,
    onClickFavorite: Function
  })

</script>

<style>
  .chapter-card {
  background-color: #FFF5B7;
}
</style>