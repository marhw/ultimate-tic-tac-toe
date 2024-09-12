<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class TicTacToeGameDocument
{
    #[MongoDB\Id]
    private string $id;

    #[MongoDB\EmbedOne(targetDocument: BoardDocument::class)]
    private BoardDocument $board;

    #[MongoDB\Field(type: "string")]
    private string $nextPlayer;

    #[MongoDB\Field(type: "string", nullable: true)]
    private ?string $winner;

    #[MongoDB\EmbedMany(targetDocument: ScoreDocument::class, storeEmptyArray: true)]
    private ArrayCollection $score;

    public function __construct()
    {
        $this->score = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
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
     * @return ArrayCollection<int, ScoreDocument>
     */
    public function getScore(): ArrayCollection
    {
        return $this->score;
    }

    /**
     * @param array<ScoreDocument> $score
     */
    public function setScore(array $score): void
    {
        $this->score->clear();
        foreach ($score as $scoreDocument) {
            $this->score[] = $scoreDocument;
        }
    }

    public function getBoard(): BoardDocument
    {
        return $this->board;
    }

    public function setBoard(BoardDocument $board): void
    {
        $this->board = $board;
    }
}
