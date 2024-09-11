<?php

namespace App\Modules\Games\Application;

use App\Modules\Games\Application\Response\GameNotStartedYet;
use App\Modules\Games\Application\Response\GameResponse;

interface GameQueryService
{
    public function getCurrentGameState(): GameResponse | null;
}
