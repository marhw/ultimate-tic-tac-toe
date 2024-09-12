import {computed, reactive} from 'vue'
import {Board, BoardPiece, GameState, Piece, Score, useGameAPI} from '../api/gameAPI.ts'
import {APIError} from "../api/api.ts";

type BoardPosition = {
    x: number
    y: number
}

type PlayerSetup = {
    player1: Piece
    player2: Piece
}

export type GameEmptyAblePiece = BoardPiece;
export type GamePiece = Piece;
export type GameScore = Score;
export type GameBoardPiece = {x: number, y: number, piece: GameEmptyAblePiece}
export type GameBoard = GameBoardPiece[];

const state = reactive<{
    gameState?: GameState;
    whoMoved?: Piece,
    playerSetup?: PlayerSetup
    board?: GameBoard,
    score?: GameScore,
    winner?: BoardPiece,
    nextPlayer?: GamePiece
}>({board: []})

function isGamePieceInverted() {
    return state.playerSetup?.player1 === 'X';
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

export function useGameModule() {
    const gameAPI = useGameAPI()

    async function startGame() {
        try {
            const currentGameState = await gameAPI.getGame()
            handleGameStateResponse(currentGameState);
        } catch (e) {
            console.error(e)
        }
    }

    async function makeAMove(position: BoardPosition) {
        if (!state.playerSetup || !state.gameState) {
            console.error('Game state not found')
            return
        }

        if (state.whoMoved === state.nextPlayer) {
            return
        }

        state.whoMoved = state.nextPlayer

        try {
            const currentGameState = await gameAPI.makeMove({
                piece: state.gameState.currentTurn,
                ...position,
            });

            handleGameStateResponse(currentGameState);
        } catch (e) {
            console.error(e);
        }
    }

    async function resetBoard() {
        try {
            const currentGameState = await gameAPI.resetGame();
            handleGameStateResponse(currentGameState);
            state.whoMoved = undefined
        } catch (e) {
            console.error(e);
        }
    }

    async function resetGame() {
        await gameAPI.deleteGame()
        state.gameState = undefined
        state.whoMoved = undefined
        state.playerSetup = undefined
        state.board = undefined
        state.score = undefined
        state.winner = undefined
        state.nextPlayer = undefined
    }

    async function pickPiece(piece: GamePiece) {
        if(piece === 'O') {
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

    const isO = (piece: GameEmptyAblePiece | undefined) => piece === 'O';
    const isX = (piece: GameEmptyAblePiece | undefined) => piece === 'X';
    const isEmptyPiece = (piece: GameEmptyAblePiece | undefined) => piece === '';

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
