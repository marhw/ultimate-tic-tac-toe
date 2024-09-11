<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Shared;

/** @ODM\EmbeddedDocument */
class ScoreDocument
{
    /** @ODM\Field(type="string") */
    private string $player;

    /** @ODM\Field(type="int") */
    private string $score;
}
