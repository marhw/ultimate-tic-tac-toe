<template>
  <Teleport to="body">
    <Modal v-if="isModalOpen" :width="400">
      <OPiece v-if="isO(winner)" />
      <XPiece v-if="isX(winner)" />
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

  const {resetBoard, winnerRef, isX, isO, isEmptyPiece} = useGameModule();
  const winner = winnerRef();

  watch(winner, (newWinner) => {
    if (newWinner === undefined) {
      return
    }

    if(isEmptyPiece(newWinner)) {
      return
    }

    isModalOpen.value = true;
    setTimeout(() => resetBoard().finally(() => isModalOpen.value = false), 2000)
  })

  const isModalOpen = ref(false);

</script>

<style scoped>
.message {
  font-size: 1.6em;
  margin-left: 30px;
}
</style>