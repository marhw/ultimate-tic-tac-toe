import {computed, reactive} from "vue";
import {
  useGameAPI,
  GameState,
  BoardPosition
} from "../api/gameAPI.ts";


const state = reactive<{gameState?: GameState}>({})

export function useGameModule() {
  const gameAPI = useGameAPI();

  async function startGame() {
    try {
      const currentGameState = await gameAPI.getGame();
      if (currentGameState instanceof Error) {
        console.error(currentGameState);
        return;
      }

      state.gameState = currentGameState;
      console.log("Game started");
    } catch (e) {
      console.error(e);
    }
  }

  async function makeAMove(position: BoardPosition) {
    try {
      if (!state.gameState) {
        console.error("Game state not found");
        return;
      }

      const currentGameState = await gameAPI.makeMove({
        piece: state.gameState.currentTurn,
        position
      });

      if (currentGameState instanceof Error) {
        console.error(currentGameState);
        return;
      }

      state.gameState = currentGameState;
    } catch (e) {
      console.error(e);
    }
  }

  async function reset() {
    try {
      const currentGameState = await gameAPI.resetGame();
      if (currentGameState instanceof Error) {
        console.error(currentGameState);
        return;
      }

      state.gameState = currentGameState;
    } catch (e) {
      console.error(e);
    }
  }

  async function nukeScores() {
    await gameAPI.deleteGame();
  }

  return {
    startGame,
    makeAMove,
    reset,
    nukeScores,
    gameState: computed(() => state.gameState),
  }
}