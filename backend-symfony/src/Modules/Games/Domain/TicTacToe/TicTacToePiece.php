<?php

namespace App\Modules\Games\Domain\TicTacToe;

use App\Modules\Games\Domain\Shared\Errors\InvalidPiece;
use App\Modules\Games\Domain\Shared\Piece;
use App\Modules\Games\Domain\Shared\Player;

final class TicTacToePiece extends Piece implements Player
{
    public static function fromString(string $piece): TicTacToePiece | InvalidPiece
    {
        $result = TicTacToeValidPieces::tryFrom($piece);

        if ($result === null) {
            return new InvalidPiece();
        }

        return $result->toPiece();
    }

    public static function fromAvailablePieces(TicTacToeValidPieces $availablePiece): self
    {
        return new TicTacToePiece($availablePiece->value);
    }

    public function symbol(): string
    {
        return $this->symbol;
    }

    public function id(): string
    {
        return $this->symbol;
    }
}
