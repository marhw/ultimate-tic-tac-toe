<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class ScoreDocument
{
    #[MongoDB\Field(type: "string")]
    private string $player;

    #[MongoDB\Field(type: "int")]
    private string $score;

    public function setPlayerId(string $playerId): void
    {
        $this->player = (string) $playerId;
    }

    public function setScore(int $scoreValue)
    {
        $this->score = $scoreValue;
    }

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function getScore(): string
    {
        return $this->score;
    }
}
