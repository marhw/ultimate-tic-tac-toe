<template>
  <div class="OPiece">
    <div class="innerOPiece" />
  </div>
</template>

<script lang="ts" setup>

</script>

<style scoped>

.innerOPiece {
  border: 3px solid rgba(0, 200, 255, 0.8); /* Visible border */
  border-radius: 50%; /* Rounded corners (optional) */
  background: rgb(13, 3, 73);
  height: 100%;
  width: 100%;
  background: radial-gradient(circle, rgba(13, 3, 73, 1) 0%, rgba(13, 3, 73, 1) 50%, rgba(45, 193, 208, 1) 100%);
  box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 30px 3px rgba(0, 199, 255, 0.5);
  -webkit-animation: animatedShadow ease 4s 1s infinite;
  -moz-animation: animatedShadow ease 4s 1s infinite;
  animation: animatedShadow ease 4s 1s infinite;
}

.OPiece {
  width: 60px;
  height: 60px;
  padding: 5px;
}

@keyframes animatedShadow {
  0% {
    box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 30px 3px rgba(0, 199, 255, 0.5);
  }
  20% {
    box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 15px 3px rgba(0, 199, 255, 0.5);
  }
  40% {
    box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 15px 6px rgba(0, 199, 255, 0.5);
  }
  60% {
    box-shadow: 0 0 8px rgb(45, 193, 208), 0 0 15px 5px rgba(0, 199, 255, 0.5);
    border-color: rgba(0, 255, 178, 0.99);
  }
  80% {
    box-shadow: 0 0 5px rgb(45, 193, 208), 0 0 15px 4px rgba(0, 199, 255, 0.5);
  }
  100% {
    box-shadow: 0 0 3px rgb(45, 193, 208), 0 0 30px 3px rgba(0, 199, 255, 0.5);
  }
}
</style>