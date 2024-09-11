<?php

namespace App\Modules\Games\Domain\TicTacToe;

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
     * @param array<TicTacToePiece> $set
     */
    private function checkWinner(array $set): TicTacToePiece | null
    {
        if (count($set) !== TicTacToeBoard::SIZE) {
            return null;
        }

        $first = $set[0];

        foreach ($set as $piece) {
            if (!$first->equals($piece)) {
                return null;
            }
        }

        return $first;
    }
}
