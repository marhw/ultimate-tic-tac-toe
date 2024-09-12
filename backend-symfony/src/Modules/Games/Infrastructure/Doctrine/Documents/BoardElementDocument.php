<?php

namespace App\Modules\Games\Infrastructure\Doctrine\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class BoardElementDocument
{
    #[MongoDB\Field(type: "int")]
    private string $x;

    #[MongoDB\Field(type: "int")]
    private string $y;

    #[MongoDB\Field(type: "string")]
    private string $piece;

    public function getX(): string
    {
        return $this->x;
    }

    public function setX(string $x): void
    {
        $this->x = $x;
    }

    public function getY(): string
    {
        return $this->y;
    }

    public function setY(string $y): void
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
