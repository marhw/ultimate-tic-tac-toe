<template>
  <div>Board</div>

  <div class="board">
    <template v-for="(row, xIndex) in gameState?.board" :key="xIndex">
      <template v-for="(cellValue, yIndex) in row" :key="xIndex + ' ' + yIndex">
        <div class="cell" @click="() => makeAMove({x: xIndex, y: yIndex})">{{ cellValue }}</div>
      </template>
    </template>
  </div>

</template>

<script lang="ts" setup>
import {computed} from "vue";
import {useGameModule} from "../modules/gameModule.ts";

const gameModule = useGameModule();

const makeAMove = (position: {x: number, y: number}) => {
  gameModule.makeAMove(position);
}

const gameState = computed(() => gameModule.gameState.value);
</script>


<style scoped>
.cell {
  display: inline-block;
  border: 1px solid black;
  text-align: center;
  line-height: 50px;
}

.board {
  display: grid;
  grid-template-columns: 50px 50px 50px;
  grid-template-rows: 50px 50px 50px;
}
</style>