<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class BoardElementDocument
{
    #[MongoDB\Field(type: "int")]
    private int $x;

    #[MongoDB\Field(type: "int")]
    private int $y;

    #[MongoDB\Field(type: "string")]
    private string $piece;

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    public function getPiece(): string
    {
        return $this->piece;
    }

    public function setPiece(string $piece): void
    {
        $this->piece = $piece;
    }
}
