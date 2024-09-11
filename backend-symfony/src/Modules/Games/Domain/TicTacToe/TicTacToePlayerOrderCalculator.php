<?php

namespace App\Modules\Games\Domain\TicTacToe;

final class TicTacToePlayerOrderCalculator
{
    public function decideFirstPlayer(): TicTacToePiece
    {
        return TicTacToeValidPieces::O->toPiece();
    }

    public function calculateNextPlayer(TicTacToePiece $currentPlayer): TicTacToePiece
    {
        $x = TicTacToeValidPieces::X->toPiece();
        $o = TicTacToeValidPieces::O->toPiece();
        return $currentPlayer->equals($x) ? $o : $x;
    }
}
