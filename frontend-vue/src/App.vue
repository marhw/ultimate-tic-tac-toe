<template>
  <div class="main-container">
    <Header id="header" />
    <template v-if="playerSetup">
      <StatusBar id="status-bar" />
      <Board />
      <WinnerPopup />
    </template>
    <template v-else>
      <PickPiece />
    </template>
    <div id="modal-space" />
  </div>
</template>

<script lang="ts" setup>
  import Board from './components/Board.vue'
  import StatusBar from './components/StatusBar.vue'
  import Header from './components/Header.vue'
  import WinnerPopup from "./components/WinnerPopup.vue";
  import {useGameModule} from "./modules/gameModule.ts";
  import PickPiece from "./components/PickPiece.vue";

  const module = useGameModule()

  const playerSetup = module.getPlayerSetupRef()
</script>

<style scoped>
.main-container {
  background: rgb(16, 0, 88);
  background: radial-gradient(
      circle,
      rgba(16, 0, 88, 1) 0%,
      rgba(7, 14, 29, 1) 80%,
      rgba(0, 0, 0, 1) 100%
  );
  display: flex;
  width: 100%;
  height: 100%;
  align-items: center;
  flex-direction: column;
}

#header {
  margin-top: 80px;
  margin-bottom: 120px;
}

#status-bar {
  margin-bottom: 80px;
}
</style>
