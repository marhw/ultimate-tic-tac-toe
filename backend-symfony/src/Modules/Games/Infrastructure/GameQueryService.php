<?php

namespace App\Modules\Games\Infrastructure;

use App\Modules\Games\Application\GameQueryService as IGameQueryService;
use App\Modules\Games\Application\Response\GameResponse;

class GameQueryService implements IGameQueryService
{
    public function getCurrentGameState(): GameResponse | null
    {
        return null;
    }
}
