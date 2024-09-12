<?php

namespace App\Modules\Games\Domain\TicTacToe;

use App\Modules\Games\Domain\Shared\BoardElement;

final class TicTacToeWinnerDecider
{
    public function decideWinner(TicTacToeBoard $board): TicTacToePiece | null
    {
        $rows = $board->getRows();
        $columns = $board->getColumns();
        $diagonals = $board->getDiagonals();

        $toCheck = array_merge($rows, $columns, $diagonals);

        foreach ($toCheck as $set) {
            $winner = $this->checkWinner($set);
            if ($winner) {
                return $winner;
            }
        }

        return null;
    }

    /**
     * @param array<BoardElement<TicTacToePiece>> $set
     */
    private function checkWinner(array $set): TicTacToePiece | null
    {
        if (count($set) !== TicTacToeBoard::SIZE) {
            return null;
        }

        $firstBoardElement = array_values($set)[0];

        foreach ($set as $boardElement) {
            if (!$firstBoardElement->piece()->equals($boardElement->piece())) {
                return null;
            }
        }

        return $firstBoardElement->piece();
    }
}
