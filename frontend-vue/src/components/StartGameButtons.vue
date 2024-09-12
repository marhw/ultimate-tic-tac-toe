<template>
  <div class="button-container">
    <BlueButton @click="startNewGame">
      Start new Game
    </BlueButton>
    <BlueButton :isDisabled="!playerSetup" @click="continueIfPossible">
      Continue
    </bluebutton>
  </div>
</template>

<script lang="ts" setup>
  import BlueButton from "./BlueButton.vue";
  import {useGameModule} from "../modules/gameModule.ts";

  const {playerSetupRef, startNewGame, continueGame} = useGameModule()

  function continueIfPossible() {
    if (!playerSetup) {
      return
    }
    continueGame()
  }

  const playerSetup = playerSetupRef();

</script>

<style scoped>
.button-container {
  display: flex;
  justify-content: space-between;
  margin-top: 40px;
  margin-bottom: 40px;
  width: 400px;
}
</style>