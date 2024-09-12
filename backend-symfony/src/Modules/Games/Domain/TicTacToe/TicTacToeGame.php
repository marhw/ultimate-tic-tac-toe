<?php

namespace App\Modules\Games\Domain\TicTacToe;

use App\Modules\Games\Domain\Game;
use App\Modules\Games\Domain\Shared\BoardPosition;
use App\Modules\Games\Domain\Shared\Errors\{GameIsOver,
    PlayerMadeMoveWithoutTurn,
    PositionIsOutOfBoardBound,
    PositionOnBoardAlreadyTaken};

class TicTacToeGame implements Game
{
    protected TicTacToeBoard $board;
    protected TicTacToePiece $nextPlayer;
    protected ?TicTacToePiece $winner;
    protected TicTacToeScore $score;
    protected TicTacToeWinnerDecider $winnerDecider;
    protected TicTacToePlayerOrderCalculator $playerOrderCalculator;

    public function __construct()
    {
        $this->board = new TicTacToeBoard();
        $this->score = new TicTacToeScore();
        $this->winner = null;
        $this->winnerDecider = new TicTacToeWinnerDecider();
        $this->playerOrderCalculator = new TicTacToePlayerOrderCalculator();
        $this->nextPlayer = $this->playerOrderCalculator->decideFirstPlayer();
    }

    public function placePiece(
        TicTacToePiece $piece,
        int $x,
        int $y
    ): PositionIsOutOfBoardBound|GameIsOver|PlayerMadeMoveWithoutTurn|PositionOnBoardAlreadyTaken|null {
        if ($this->winner) {
            return new GameIsOver();
        }

        if (!$this->nextPlayer->equals($piece)) {
            return new PlayerMadeMoveWithoutTurn();
        }

        $position = BoardPosition::create($x, $y, $this->board->size());

        if ($position instanceof PositionIsOutOfBoardBound) {
            return $position;
        }

        if ($this->board->isPositionOccupied($position)) {
            return new PositionOnBoardAlreadyTaken();
        }

        $this->board->setPieceAt($position, $piece);

        $this->checkWinner();

        if ($this->winner === null) {
            $this->switchPlayer();
        }

        return null;
    }

    private function checkWinner(): void
    {
        $winner = $this->winnerDecider->decideWinner($this->board);
        if ($winner !== null) {
            $this->winner = $winner;
            $this->score->addScoreForPlayer($winner, 1);
        }
    }

    private function switchPlayer(): void
    {
        $this->nextPlayer = $this->playerOrderCalculator->calculateNextPlayer($this->nextPlayer);
    }

    public function resetGame(): void
    {
        $this->board->reset();
        $this->winner = null;
        $this->switchPlayer();
    }
}
