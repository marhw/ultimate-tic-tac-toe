<?php

namespace App\Modules\Games\Domain\TicTacToe;

enum TicTacToeValidPieces: string
{
    case X = 'X';
    case O = 'O';

    public function toPiece(): TicTacToePiece
    {
        return TicTacToePiece::fromAvailablePieces($this);
    }
}
