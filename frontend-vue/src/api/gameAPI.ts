import {useApi} from './api.ts'

export type Piece = 'X' | 'O';
export type BoardPiece = Piece | '';

export type Score = {
    X: number,
    O: number
}

export type Board = BoardPiece[][]

export type GameState = {
    board: Board,
    score: Score,
    currentTurn: Piece,
    victory: BoardPiece
}

export type MakeMovePayload = {
    x: number
    y: number
    piece: Piece
}

export function useGameAPI() {
    const api = useApi()

    return {
        getGame: () => api.getReq<GameState>(`/`),
        makeMove: (payload: MakeMovePayload) => api.postReq<GameState, MakeMovePayload>(`/move`, payload),
        resetGame: () => api.postReq<GameState, object>(`/restart`, {}),
        deleteGame: () => api.deleteReq<Pick<GameState, 'currentTurn'>>(`/`),
    }
}
