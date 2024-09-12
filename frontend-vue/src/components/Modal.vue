<template>
  <div class="outer-modal">
    <div :style="style" class="inner-modal">
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>
  import {computed} from "vue";

  const props = defineProps<{
    width?: number;
  }>();

  const style = computed(() => ({
    width: props.width ? `${props.width}px` : 'auto',
  }));
</script>

<style scoped>
.outer-modal {
  position: fixed;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  top: 0;
  left: 0;
}

.inner-modal {
  position: absolute;
  background-color: rgb(0, 0, 0);
  border-radius: 10px;
  padding: 20px 40px;
  box-shadow: 0 0 2px rgba(0, 51, 47, 0.39);
  border: 1px solid #3445b6;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>