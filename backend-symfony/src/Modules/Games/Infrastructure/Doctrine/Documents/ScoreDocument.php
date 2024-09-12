<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class ScoreDocument
{
    #[MongoDB\Field(type: "string")]
    private string $player;

    #[MongoDB\Field(type: "int")]
    private int $score;

    public function getPlayer(): string
    {
        return $this->player;
    }

    public function setPlayer(string $player): void
    {
        $this->player = $player;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $scoreValue): void
    {
        $this->score = $scoreValue;
    }
}
