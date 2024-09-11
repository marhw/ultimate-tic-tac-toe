<?php

namespace App\Modules\Games\Domain\TicTacToe;

use App\Modules\Games\Domain\Shared\Board;
use App\Modules\Games\Domain\Shared\BoardSize;

/**
 * @extends Board<TicTacToePiece>
 */
final class TicTacToeBoard extends Board
{
    public const SIZE = 3;

    /**
     * @param array<TicTacToePiece> $pieces
     */
    public function __construct(array $pieces = [])
    {
        parent::__construct(new BoardSize(self::SIZE, self::SIZE), $pieces);
    }

    /**
     * @return array<TicTacToePiece>
     */
    public function getTopLeftToBottomRightDiagonal(): array
    {
        $diagonal = [];
        for ($i = 0; $i < self::SIZE; $i++) {
            $index = $this->coordsToBoardIndex($i, $i);
            $diagonal[] = $this->getPieceByIndex($index);
        }

        return array_filter($diagonal);
    }

    /**
     * @return array<TicTacToePiece>
     */
    public function getBottomLeftToTopRightDiagonal(): array
    {
        $diagonal = [];
        for ($i = 0; $i < self::SIZE; $i++) {
            $index = $this->coordsToBoardIndex($i, self::SIZE - 1 - $i);
            $diagonal[] = $this->getPieceByIndex($index);
        }

        return array_filter($diagonal);
    }

    /**
     * @return array<array<TicTacToePiece>>
     */
    public function getDiagonals(): array
    {
        return [
            $this->getTopLeftToBottomRightDiagonal(),
            $this->getBottomLeftToTopRightDiagonal()
        ];
    }
}
