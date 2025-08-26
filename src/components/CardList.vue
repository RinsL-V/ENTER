<template>
  <div class="grid grid-cols-5 gap-5 min-h-[400px]">
    <Card
      v-for="item in items"
      :key="item.id"
      :id="item.id"
      :title="item.title"
      :description="item.description"
      :image-url="item.imageUrl"
      :price="item.price"
      :is-favorite="false"
      :is-added="false"
      :on-click-add="() => {}"
      :on-click-favorite="() => {}"
    />

    />
  </div>
</template>


<script setup>
import Card from './Card.vue';

defineProps({
  items: Array
})

const onClickAdd = () => {
  console.log('Глава добавлена!');
  alert('Добавлено в корзину!');
};
</script>