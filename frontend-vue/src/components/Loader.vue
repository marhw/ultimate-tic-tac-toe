<template>
  <div class="loader" />
</template>

<script lang="ts" setup>

</script>

<style scoped>

.loader {
  width: 50px;
  aspect-ratio: 1;
  border-radius: 50%;
  border: 4px solid;
  border-color: rgba(12, 232, 255, 0.67) #0000;
  box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 4px rgba(0, 199, 255, 0.5);
  animation: rotate 1s infinite;
}

@keyframes rotate {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>