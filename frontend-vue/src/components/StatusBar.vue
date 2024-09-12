<script lang="ts" setup>
import { useGameModule } from '../modules/gameModule.ts'

const gameModule = useGameModule()

const reset = () => gameModule.resetBoard()
const startGame = () => gameModule.startGame()
const resetGame = () => gameModule.resetGame()
</script>

<template>
    <button type="button" @click="startGame">Start Game</button>
    <button type="button" @click="reset">Reset Board</button>
    <button type="button" @click="resetGame">Reset Game</button>
</template>

<style scoped></style>
