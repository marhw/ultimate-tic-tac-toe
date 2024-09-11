<?php

namespace App\Modules\Games\Infrastructure\Doctrine;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class TicTacToeGameDocument
{
    /** @ODM\Id */
    private string $id;

    /** @ODM\EmbedMany(targetDocument=BoardElementDocument::class) */
    private array $board;

    /** @ODM\Field(type="string") */
    private string $nextPlayer;

    /** @ODM\Field(type="string", nullable=true) */
    private ?string $winner;

    /** @ODM\EmbedMany(targetDocument=ScoreDocument::class) */
    private array $score;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @param array<int, array<int, string>> $board
     */
    public function setBoard(array $board): void
    {
        $this->board = $board;
    }

    public function getNextPlayer(): string
    {
        return $this->nextPlayer;
    }

    public function setNextPlayer(string $nextPlayer): void
    {
        $this->nextPlayer = $nextPlayer;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): void
    {
        $this->winner = $winner;
    }

    /**
     * @return array<string, int>
     */
    public function getScore(): array
    {
        return $this->score;
    }

    /**
     * @param array<string, int> $score
     */
    public function setScore(array $score): void
    {
        $this->score = $score;
    }
}
