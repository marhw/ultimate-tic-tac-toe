import {useApi} from "./api.ts";

export type Piece = "x" | "o";
export type BoardPiece = Piece | "";

export type GameState = {
  board: BoardPiece[][],
  score: Record<Piece, number>,
  currentTurn: Piece,
  victory: BoardPiece,
}

export type BoardPosition = {
  x: number,
  y: number
}

export function useGameAPI() {
  const api = useApi();

  return {
    getGame: () => api.getReq<GameState>(`/`),
    makeMove: ({piece, position}: {piece: Piece, position: BoardPosition}) => api.postReq<GameState, BoardPosition>(`/${piece}`, {...position}),
    resetGame: () => api.postReq<GameState, {}>(`/restart`, {}),
    deleteGame: () => api.deleteReq<Pick<GameState, 'currentTurn'>>(`/`),
  }
}