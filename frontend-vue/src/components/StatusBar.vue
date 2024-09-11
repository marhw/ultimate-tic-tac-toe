<template>
  <Button @click="startGame">Start Game</Button>
  <Button @click="reset">Reset</Button>
</template>

<script setup lang="ts">
  import {useGameModule} from "../modules/gameModule.ts";

  const gameModule = useGameModule()

  const reset = () => gameModule.reset();
  const startGame = () => gameModule.startGame();
</script>

<style scoped>

</style>