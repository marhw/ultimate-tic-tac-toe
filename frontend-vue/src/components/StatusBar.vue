<template>
  <div class="status-bar">
    <template v-if="score">
      <div class="cell">
        <BlueButton class="button" @click="resetBoard">
          Reset Board
        </BlueButton>
      </div>
      <div class="cell">
        <OPiece />
        <div v-if="isO(nextPlayer)" class="next-player" />
      </div>
      <span class="score-text cell">{{ score.O }}</span>
      <span class="score-text cell">:</span>
      <span class="score-text cell">{{ score.X }}</span>
      <div class="cell">
        <XPiece />
        <div v-if="isX(nextPlayer)" class="next-player" />
      </div>
      <div class="cell">
        <BlueButton class="button" @click="resetGame">
          Reset Game
        </BlueButton>
      </div>
    </template>
  </div>
</template>

<script lang="ts" setup>
  import {useGameModule} from '../modules/gameModule.ts'
  import BlueButton from "./BlueButton.vue";
  import OPiece from "./OPiece.vue";
  import XPiece from "./XPiece.vue";

  const {
    resetBoard,
    resetGame,
    scoreRef,
    nextPlayerRef,
    isO,
    isX,
  } = useGameModule()

  const score = scoreRef();
  const nextPlayer = nextPlayerRef();
</script>

<style scoped>
.status-bar {
  display: grid;
  justify-content: center;
  grid-template-columns: 250px 120px 20px 20px 20px 120px 250px;
}

.cell {
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}

.score-text {
  font-size: 1.6em;
}

.next-player {
  position: absolute;
  margin-bottom: 110px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #c09a00;
  box-shadow: 0 0 10px rgba(255, 253, 217, 0.87);
  -webkit-animation: nextPlayerAnimation linear 1.5s infinite;
  -moz-animation: nextPlayerAnimation linear 1.5s infinite;
  animation: nextPlayerAnimation linear 1.5s infinite;
}

@keyframes nextPlayerAnimation {
  0% {
    margin-top: 0;
  }

  25% {
    margin-top: -20px;
  }

  50% {
    margin-top: 0;
  }

  75% {
    margin-top: 20px;
  }

  100% {
    margin-top: 0;
  }
}
</style>
