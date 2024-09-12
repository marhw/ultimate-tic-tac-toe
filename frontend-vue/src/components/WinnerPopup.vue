<template>
  <Teleport to="body">
    <Modal v-if="open" :width="400">
      <OPiece v-if="isO(localWinner)" />
      <XPiece v-if="isX(localWinner)" />
      <span class="message">has won!</span>
    </Modal>
  </Teleport>
</template>

<script setup lang="ts">
  import Modal from "./Modal.vue";
  import {ref, watch} from "vue";
  import {useGameModule} from "../modules/gameModule.ts";
  import OPiece from "./OPiece.vue";
  import XPiece from "./XPiece.vue";
  import { BoardPiece } from "../api/gameAPI";

  const {resetBoard, getWinnerRef, isX, isO} = useGameModule();
  const winnerRef = getWinnerRef();

  watch(winnerRef, (winner) => {
    if (winner === undefined) {
      return
    }

    if (winner !== "") {
      open.value = true;
      localWinner.value = winner;
      setTimeout(() => resetBoard().then(() => {
        open.value = false
        localWinner.value = undefined;
      }), 2000)
    }
  })
  const localWinner = ref<BoardPiece | undefined>(undefined);

  const open = ref(false);

</script>

<style scoped>
.message {
  font-size: 1.6em;
  margin-left: 30px;
}
</style>