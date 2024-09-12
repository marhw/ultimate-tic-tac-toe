<template>
  <div class="button">
    <div class="inner-button glowing-text">
      <slot />
    </div>
  </div>
</template>

<script lang="ts" setup>

</script>

<style scoped>

.button {
  color: #2dc1d0;
  background-color: rgba(12, 232, 255, 0.67);
  padding: 3px;
  border-radius: 20px;
  outline: none;
  box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 3px rgba(0, 199, 255, 0.5);
  font-size: 1.3em;
  display: flex;
  justify-content: center;
  align-items: center;
}

.inner-button {
  background-color: #0c033d;
  padding: 20px 20px;
  border-radius: 17px;
  box-shadow: 0 0 20px rgba(252, 252, 252, 0.85), 0 0 40px rgba(0, 200, 255, 0.8);
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
}

.inner-button:hover {
  background-color: rgba(13, 3, 73, 0.82);
  -webkit-transition: background-color 100ms linear;
  -ms-transition: background-color 100ms linear;
  transition: background-color 100ms linear;
}

.glowing-text {
  color: #9afff6;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.8),
  0 0 10px rgba(255, 255, 255, 0.8),
  0 0 1px rgba(255, 255, 255, 0.6),
  0 0 1px rgba(0, 200, 255, 0.5);
}
</style>