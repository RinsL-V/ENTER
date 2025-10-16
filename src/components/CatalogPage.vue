<template>
  <div class="min-h-screen bg-black">
    <CatalogSection @open-chapter="handleOpenChapter" />
  </div>
</template>

<script setup>
import CatalogSection from './CatalogSection.vue'

const emit = defineEmits(['open-chapter'])

const handleOpenChapter = (chapter) => {
  console.log('CatalogPage received open-chapter:', chapter)
  emit('open-chapter', chapter)
}
</script>