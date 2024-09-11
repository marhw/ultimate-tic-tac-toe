<?php

namespace App\Modules\Games;

use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\Application\Response\GameResponse;
use App\Modules\Games\Application\Response\PiecePlacedOutOfTurn;
use App\Modules\Games\Application\Response\PositionInBoardAlreadyTaken;

interface GamesModule
{
    public function startGame(): void;
    public function makeMove(int $x, int $y, string $piece): PositionInBoardAlreadyTaken | PiecePlacedOutOfTurn | null;
    public function reset(): void;
    public function removeGame(): void;
    public function getCurrentGameState(): GameResponse | GameNotStartedYet;
}
