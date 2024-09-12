import { useApi } from './api.ts'

export type Piece = 'x' | 'o'
export type BoardPiece = Piece | ''

export type GameState = {
    board: BoardPiece[][]
    score: Record<Piece, number>
    currentTurn: Piece
    victory: BoardPiece
}

export type BoardPosition = {
    x: number
    y: number
}

export type MakeMovePayload = {
    x: number
    y: number
    piece: Piece
}

export function useGameAPI() {
    const api = useApi()

    return {
        getGame: () => api.getReq<GameState>(``),
        makeMove: (payload: MakeMovePayload) =>
            api.postReq<GameState, MakeMovePayload>(`/move`, payload),
        resetGame: () => api.postReq<GameState, object>(`/restart`, {}),
        deleteGame: () => api.deleteReq<Pick<GameState, 'currentTurn'>>(`/`),
    }
}
