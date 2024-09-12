import {computed, reactive} from 'vue'
import {Board, BoardPiece, GameState, Piece, Score, useGameAPI} from '../api/gameAPI.ts'
import {APIError} from "../api/api.ts";

type GameBoardPosition = {
    x: number
    y: number
}

type GamePlayerSetup = {
    player1: Piece
    player2: Piece
}

export type GameEmptyAblePiece = BoardPiece;
export type GamePiece = Piece;
export type GameScore = Score;
export type GameBoardPiece = GameBoardPosition & { piece: GameEmptyAblePiece }
export type GameBoard = GameBoardPiece[];

export enum GameProgressState {
    NOT_STARTED = 'NOT_STARTED',
    PICKING_PIECE = 'PICKING_PIECE',
    IN_PROGRESS = 'IN_PROGRESS',
}

const state = reactive<{
    isGameStarted: boolean;
    gameStateFromApi?: GameState;
    playerSetup?: GamePlayerSetup
    board?: GameBoard,
    score?: GameScore,
    winner?: GameEmptyAblePiece,
    nextPlayer?: GamePiece,
    isApiCallInProgress: boolean,
    gameProgressState: GameProgressState
}>({
    board: [],
    isApiCallInProgress: false,
    playerSetup: loadPlayerSetupFromLocalStorage(),
    isGameStarted: false,
    gameProgressState: GameProgressState.NOT_STARTED
});


const isO = (piece: GameEmptyAblePiece | undefined) => piece === 'O';
const isX = (piece: GameEmptyAblePiece | undefined) => piece === 'X';
const isEmptyPiece = (piece: GameEmptyAblePiece | undefined) => piece === '';

function isGamePieceInverted() {
    return isX(state.playerSetup?.player1);
}

function getPieceFromPerspectiveOfPlayer<T>(piece: T) {
    if (state.playerSetup === undefined) {
        console.error("playerSetup should be defined");
        return piece;
    }

    if (isGamePieceInverted()) {
        return piece === 'O' ? 'X' : piece === 'X' ? 'O' : piece;
    }

    return piece
}

function mapApiBoardToGameBoard(apiBoard: Board): GameBoard {
    return apiBoard.flatMap((row, x) => row.map((piece, y) => ({x, y, piece: getPieceFromPerspectiveOfPlayer(piece)})))
}

function mapApiScoreToGameScore(apiScore: Score): GameScore {
    if (isGamePieceInverted()) {
        return {O: apiScore.X, X: apiScore.O}
    }

    return apiScore
}

function mapApiVictoryToGameWinner(apiWinner: BoardPiece): GamePiece | "" {
    return getPieceFromPerspectiveOfPlayer(apiWinner);
}

function mapApiCurrentTurnToGameNextPlayer(apiCurrentTurn: Piece): GamePiece {
    return getPieceFromPerspectiveOfPlayer(apiCurrentTurn);
}

function handleGameStateResponse(gameState: GameState | Error | APIError) {
    if (gameState instanceof Error) {
        console.error(gameState)
        return
    }

    state.gameStateFromApi = gameState
    state.board = mapApiBoardToGameBoard(gameState.board);
    state.score = mapApiScoreToGameScore(gameState.score);
    state.winner = mapApiVictoryToGameWinner(gameState.victory);
    state.nextPlayer = mapApiCurrentTurnToGameNextPlayer(gameState.currentTurn);
}

const freeApi = () => state.isApiCallInProgress = false;
const lockApi = () => state.isApiCallInProgress = true;

function savePlayerSetupToLocalStorage(playerSetup: GamePlayerSetup) {
    localStorage.setItem('playerSetup', JSON.stringify(playerSetup));
}

function loadPlayerSetupFromLocalStorage(): GamePlayerSetup | undefined {
    const playerSetup = localStorage.getItem('playerSetup');
    return playerSetup ? JSON.parse(playerSetup) : undefined;
}

function clearPlayerSetupFromLocalStorage() {
    localStorage.removeItem('playerSetup');
}

export function useGameModule() {
    const gameAPI = useGameAPI()

    async function startNewGame() {
        await resetGame();
        state.gameProgressState = GameProgressState.PICKING_PIECE;
    }
    async function continueGame() {
        await loadGame();
        state.gameProgressState = GameProgressState.IN_PROGRESS;
    }

    async function loadGame() {
        if (state.isApiCallInProgress) {
            return;
        }

        try {
            lockApi();
            const currentGameState = await gameAPI.getGame()
            handleGameStateResponse(currentGameState);
        } catch (e) {
            console.error(e)
        } finally {
            freeApi()
        }
    }

    async function makeAMove(position: GameBoardPosition) {
        if (state.isApiCallInProgress) {
            return;
        }

        if (!state.playerSetup || !state.gameStateFromApi) {
            console.error('Game state not found')
            return
        }

        try {
            lockApi();
            const currentGameState = await gameAPI.makeMove({
                piece: state.gameStateFromApi.currentTurn,
                ...position,
            });

            handleGameStateResponse(currentGameState);
        } catch (e) {
            console.error(e);
        } finally {
            freeApi();
        }
    }

    async function resetBoard() {
        if (state.isApiCallInProgress) {
            return;
        }

        try {
            lockApi();
            const currentGameState = await gameAPI.resetGame();
            handleGameStateResponse(currentGameState);
        } catch (e) {
            console.error(e);
        } finally {
            freeApi();
        }
    }

    async function resetGame() {
        if (state.isApiCallInProgress) {
            return;
        }

        lockApi();
        await gameAPI.deleteGame().finally(() => freeApi())
        state.gameStateFromApi = undefined
        state.playerSetup = undefined
        state.board = undefined
        state.score = undefined
        state.winner = undefined
        state.nextPlayer = undefined
        clearPlayerSetupFromLocalStorage();
        state.gameProgressState = GameProgressState.NOT_STARTED;
    }

    async function pickPiece(piece: GamePiece) {
        if (isO(piece)) {
            state.playerSetup = {player1: 'O', player2: 'X'}
        } else {
            state.playerSetup = {player1: 'X', player2: 'O'}
        }

        savePlayerSetupToLocalStorage(state.playerSetup);
        state.gameProgressState = GameProgressState.IN_PROGRESS;
        await loadGame();
    }

    const isGameStartedRef = computed(() => state.isGameStarted);
    const boardRef = computed(() => state.board);
    const scoreRef = computed(() => state.score);
    const nextPlayerRef = computed(() => state.nextPlayer);
    const winnerRef = computed(() => state.winner);
    const playerSetupRef = computed(() => state.playerSetup);
    const gameProgressStateRef = computed(() => state.gameProgressState);
    const isApiCallInProgressRef = computed(() => state.isApiCallInProgress);

    return {
        startNewGame,
        continueGame,
        makeAMove,
        resetBoard,
        resetGame,
        pickPiece,
        isO,
        isX,
        isEmptyPiece,
        isGameStartedRef: () => isGameStartedRef,
        scoreRef: () => scoreRef,
        nextPlayerRef: () => nextPlayerRef,
        winnerRef: () => winnerRef,
        boardRef: () => boardRef,
        playerSetupRef: () => playerSetupRef,
        gameProgressStateRef: () => gameProgressStateRef,
        isApiCallInProgressRef: () => isApiCallInProgressRef
    }
}
