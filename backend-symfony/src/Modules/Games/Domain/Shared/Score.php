<?php

namespace App\Modules\Games\Domain\Shared;

abstract class Score
{
    /**
     * @var array<string, int>
     */
    protected array $score = [];

    protected function registerPlayer(Player $player): void
    {
        $playerId = $player->id();
        if (!array_key_exists($playerId, $this->score)) {
            $this->score[$playerId] = 0;
        }
    }

    public function addScoreForPlayer(Player $player, int $score): void
    {
        $this->score[$player->id()] += $score;
    }

    /**
     * @return array<string, int>
     */
    public function getCurrentScore(): array
    {
        return $this->score;
    }
}
