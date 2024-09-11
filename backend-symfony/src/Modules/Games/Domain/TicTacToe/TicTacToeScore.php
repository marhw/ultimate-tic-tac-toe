<?php

namespace App\Modules\Games\Domain\TicTacToe;

use App\Modules\Games\Domain\Shared\Score;

final class TicTacToeScore extends Score
{
    public function __construct()
    {
        $this->registerPlayer(TicTacToeValidPieces::X->toPiece());
        $this->registerPlayer(TicTacToeValidPieces::O->toPiece());
    }
}
