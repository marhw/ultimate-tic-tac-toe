<?php

namespace App\Modules\Games\Application;

use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\Application\Response\PiecePlacedOutOfTurn;
use App\Modules\Games\Application\Response\PositionInBoardAlreadyTaken;
use App\Modules\Games\Domain\GameRepository;
use App\Modules\Games\Domain\Shared\Errors\GameIsOver;
use App\Modules\Games\Domain\Shared\Errors\InvalidPiece;
use App\Modules\Games\Domain\Shared\Errors\PlayerMadeMoveWithoutTurn;
use App\Modules\Games\Domain\Shared\Errors\PositionIsOutOfBoardBound;
use App\Modules\Games\Domain\Shared\Errors\PositionOnBoardAlreadyTaken;
use App\Modules\Games\Domain\TicTacToe\TicTacToeGame;
use App\Modules\Games\Domain\TicTacToe\TicTacToePiece;

class TicTacToeGameService
{
    public function __construct(private readonly GameRepository $gameRepository)
    {
    }

    public function startGame(): void
    {
        $game = $this->gameRepository->findGame();

        if ($game instanceof TicTacToeGame) {
            return;
        }

        $game = new TicTacToeGame();
        $this->gameRepository->save($game);
    }

    public function makeMove(
        int $x,
        int $y,
        string $piece
    ): GameNotStartedYet | PiecePlacedOutOfTurn | PositionInBoardAlreadyTaken | null {
        $game = $this->gameRepository->findGame();

        if (!($game instanceof TicTacToeGame)) {
            return null;
        }

        $ticTacToePiece = TicTacToePiece::fromString($piece);

        if ($ticTacToePiece instanceof InvalidPiece) {
            return null;
        }

        $result = $game->placePiece($ticTacToePiece, $x, $y);

        return match (true) {
            $result instanceof PlayerMadeMoveWithoutTurn => new PiecePlacedOutOfTurn(),
            $result instanceof PositionOnBoardAlreadyTaken => new PositionInBoardAlreadyTaken(),
            $result instanceof GameIsOver, $result instanceof PositionIsOutOfBoardBound, $result === null => null,
        };
    }

    public function reset(): void
    {
        $game = $this->gameRepository->findGame();

        if (!($game instanceof TicTacToeGame)) {
            return;
        }

        $game->resetGame();
    }

    public function removeGame(): void
    {
        $game = $this->gameRepository->findGame();

        if (!($game instanceof TicTacToeGame)) {
            return;
        }

        $this->gameRepository->remove($game);
    }
}
