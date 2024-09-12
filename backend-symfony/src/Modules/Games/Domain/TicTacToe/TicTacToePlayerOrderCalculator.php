<?php

namespace App\Modules\Games\Domain\TicTacToe;

final class TicTacToePlayerOrderCalculator
{
    public function selectPlayerForNextGame(TicTacToePiece | null $playerWhichLastTimeStarted): TicTacToePiece
    {
        $x = TicTacToeValidPieces::X->toPiece();
        $o = TicTacToeValidPieces::O->toPiece();

        if ($playerWhichLastTimeStarted === null) {
            return $o;
        }

        return $playerWhichLastTimeStarted->equals($x) ? $o : $x;
    }

    public function selectPlayerForNextTurn(TicTacToePiece $currentPlayer): TicTacToePiece
    {
        $x = TicTacToeValidPieces::X->toPiece();
        $o = TicTacToeValidPieces::O->toPiece();
        return $currentPlayer->equals($x) ? $o : $x;
    }
}
