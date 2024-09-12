<template>
  <div class="pick-piece">
    <div class="cell pickable" @click="pick('O')">
      <OPiece />
    </div>
    <div class="cell">
      Or
    </div>
    <div class="cell pickable" @click="pick('X')">
      <XPiece />
    </div>
  </div>
</template>

<script lang="ts" setup>
  import OPiece from "./OPiece.vue";
  import XPiece from "./XPiece.vue";
  import {GamePiece, useGameModule} from "../modules/gameModule.ts";

  const module = useGameModule();
  const pick = (piece: GamePiece) => {
    module.pickPiece(piece)
  }

</script>

<style scoped>
.pick-piece {
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 1.6em;
  margin-top: 100px;
}

.pickable:hover {
  border: 2px solid #55b634;
  box-shadow: 0 0 10px #469a7a;
  border-radius: 5px;
  cursor: pointer;
}

.cell {
  display: flex;
  padding: 20px;
  justify-content: center;
  align-items: center;
  border: 2px solid rgba(85, 182, 52, 0);
}
</style>