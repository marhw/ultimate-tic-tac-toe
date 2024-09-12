<template>
  <div class="XPiece">
    <div class="mr line" />
    <div class="rr line" />
  </div>
</template>

<script lang="ts" setup>

</script>

<style scoped>
.XPiece {
  position: relative;
  border-radius: 50%; /* Rounded corners (optional) */
  width: 60px;
  height: 60px;
  transform: rotate(45deg);
}

.line {
  position: absolute;
  width: 60px;
  height: 60px;
  border-radius: 1px;
  box-shadow: 0 0 5px rgb(206, 94, 255), 0 0 10px 1px rgba(222, 0, 255, 0.5);
  -webkit-animation: animatedRotations ease 4s 1s infinite;
  -moz-animation: animatedRotations ease 4s 1s infinite;
  animation: animatedRotations ease 4s 1s infinite;
}

.mr {
  top: calc(50%);
  left: 1px;
  border-top: 3px solid rgb(157, 0, 192);
  height: 1px;
}

.rr {
  left: calc(50%);
  top: 1px;
  border-left: 3px solid rgb(157, 0, 192);
  width: 1px;
}

@keyframes animatedRotations {
  0% {
    box-shadow: 0 0 2px rgb(206, 94, 255), 0 0 10px 1px rgba(222, 0, 255, 0.5);
  }

  20% {
    box-shadow: 0 0 2px rgb(206, 94, 255), 0 0 10px 0 rgba(222, 0, 255, 0.5);
  }

  40% {
    box-shadow: 0 0 2px rgb(206, 94, 255), 0 0 10px 3px rgba(222, 0, 255, 0.5);
  }

  60% {
    box-shadow: 0 0 2px rgb(206, 94, 255), 0 0 10px 4px rgba(222, 0, 255, 0.5);
    border-color: rgba(115, 0, 117, 0.2);
  }

  80% {
    box-shadow: 0 0 10px rgb(206, 94, 255), 0 0 10px 1px rgba(222, 0, 255, 0.5);
  }

  100% {
    box-shadow: 0 0 2px rgb(206, 94, 255), 0 0 10px 1px rgba(222, 0, 255, 0.5);
  }
}
</style>