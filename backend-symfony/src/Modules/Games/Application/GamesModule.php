<?php

namespace App\Modules\Games\Application;

use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\Application\Response\GameResponse;
use App\Modules\Games\Application\Response\PiecePlacedOutOfTurn;
use App\Modules\Games\Application\Response\PositionInBoardAlreadyTaken;
use App\Modules\Games\GamesModule as IGamesModule;

class GamesModule implements IGamesModule
{
    public function __construct(
        private TicTacToeGameService $gameService,
        private GameQueryService $gameQueryService
    ) {
    }

    public function startGame(): void
    {
        $this->gameService->startGame();
    }

    public function makeMove(int $x, int $y, string $piece): PositionInBoardAlreadyTaken | PiecePlacedOutOfTurn | null
    {
        return $this->gameService->makeMove($x, $y, $piece);
    }

    public function reset(): void
    {
        $this->gameService->reset();
    }

    public function removeGame(): void
    {
        $this->gameService->removeGame();
    }

    public function getCurrentGameState(): GameResponse|GameNotStartedYet
    {
        return $this->gameQueryService->getCurrentGameState();
    }
}
