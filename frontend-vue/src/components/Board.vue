<template>
  <div class="board">
    <template v-if="board">
      <template v-for="(element, elementIndex) in board" :key="elementIndex">
        <div v-if="isO(element.piece)" class="cell">
          <OPiece />
        </div>
        <div v-if="isX(element.piece)" class="cell">
          <XPiece />
        </div>
        <div
          v-if="isEmptyPiece(element.piece)" class="empty-cell cell"
          @click="() => makeAMove({ x: element.x, y: element.y })"
        />
      </template>
    </template>
  </div>
</template>

<script lang="ts" setup>
  import {useGameModule} from '../modules/gameModule.ts'
  import OPiece from './OPiece.vue'
  import XPiece from './XPiece.vue'

  const {makeAMove, boardRef, isO, isX, isEmptyPiece} = useGameModule()

  const board = boardRef();
</script>

<style scoped>
.cell {
  border: 1px solid #3445b6;
  display: flex;
  justify-content: center;
  align-items: center;
}

.empty-cell {
  cursor: pointer;
}

.board {
  display: grid;
  grid-template-columns: 80px 80px 80px;
  grid-template-rows: 80px 80px 80px;
}
</style>
