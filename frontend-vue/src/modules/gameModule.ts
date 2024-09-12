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
export type GameBoardPiece = GameBoardPosition & {piece: GameEmptyAblePiece}
export type GameBoard = GameBoardPiece[];

const state = reactive<{
    gameState?: GameState;
    playerSetup?: GamePlayerSetup
    board?: GameBoard,
    score?: GameScore,
    winner?: GameEmptyAblePiece,
    nextPlayer?: GamePiece,
    apiCallInProgress: boolean
}>({board: [], apiCallInProgress: false})

const isO = (piece: GameEmptyAblePiece | undefined) => piece === 'O';
const isX = (piece: GameEmptyAblePiece | undefined) => piece === 'X';
const isEmptyPiece = (piece: GameEmptyAblePiece | undefined) => piece === '';

function isGamePieceInverted() {
    return isX(state.playerSetup?.player1);
}

function getPieceFromPerspectiveOfPlayer<T>(piece: T)
{
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

    state.gameState = gameState
    state.board = mapApiBoardToGameBoard(gameState.board);
    state.score = mapApiScoreToGameScore(gameState.score);
    state.winner = mapApiVictoryToGameWinner(gameState.victory);
    state.nextPlayer = mapApiCurrentTurnToGameNextPlayer(gameState.currentTurn);
}

const freeApi = () => state.apiCallInProgress = false;
const lockApi = () => state.apiCallInProgress = true;

export function useGameModule() {
    const gameAPI = useGameAPI()

    async function startGame() {
        if (state.apiCallInProgress) {
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
        if (state.apiCallInProgress) {
            return;
        }

        if (!state.playerSetup || !state.gameState) {
            console.error('Game state not found')
            return
        }

        try {
            lockApi();
            const currentGameState = await gameAPI.makeMove({
                piece: state.gameState.currentTurn,
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
        if (state.apiCallInProgress) {
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
        if (state.apiCallInProgress) {
            return;
        }

        lockApi();
        await gameAPI.deleteGame().finally(() => freeApi())
        state.gameState = undefined
        state.playerSetup = undefined
        state.board = undefined
        state.score = undefined
        state.winner = undefined
        state.nextPlayer = undefined
    }

    async function pickPiece(piece: GamePiece) {
        if(isO(piece)) {
            state.playerSetup = {player1: 'O', player2: 'X'}
        } else {
            state.playerSetup = {player1: 'X', player2: 'O'}
        }

        await startGame();
    }

    const boardRef = computed(() => state.board);
    const scoreRef = computed(() => state.score);
    const nextPlayerRef = computed(() => state.nextPlayer);
    const winnerRef = computed(() => state.winner);
    const playerSetupRef = computed(() => state.playerSetup);

    return {
        makeAMove,
        resetBoard,
        resetGame,
        pickPiece,
        isO,
        isX,
        isEmptyPiece,
        getScoreRef: () => scoreRef,
        getNextPlayerRef: () => nextPlayerRef,
        getWinnerRef: () => winnerRef,
        getBoardRef: () => boardRef,
        getPlayerSetupRef: () => playerSetupRef,
    }
}
